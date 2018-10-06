<?php

namespace Acceptance\Product\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use TalkingBit\BddExample\FileReader\CSVFileReader;
use TalkingBit\BddExample\Persistence\InMemoryProductRepository;
use TalkingBit\BddExample\Product;
use TalkingBit\BddExample\ProductRepository;
use TalkingBit\BddExample\UpdatePricesFromUploadedFile;
use TalkingBit\BddExample\VO\FilePath;
use Throwable;

/**
 * Defines application features from the specific context.
 */
class MassiveUpdateContext implements Context
{
    /** @var string */
    private $pathToFile;
    /** @var UpdatePricesFromUploadedFile */
    private $updatePricesFromUploadedFile;
    /** @var ProductRepository */
    private $productRepository;
    /** @var Throwable */
    private $lastException;

    public function __construct()
    {
        $this->productRepository = new InMemoryProductRepository();
        $this->updatePricesFromUploadedFile = new UpdatePricesFromUploadedFile(
            $this->productRepository,
            new CSVFileReader()
        );
    }

    /**
     * @Given There are current prices in the system
     */
    public function thereAreCurrentPricesInTheSystem(TableNode $productTable): void
    {
        foreach ($productTable as $productRow) {
            $product = new Product(
                $productRow['id'],
                $productRow['name'],
                $productRow['price']
            );
            $this->productRepository->store($product);
        }

        $this->assertTheseProductsAreInTheRepository($productTable);
    }

    /**
     * @Given /I have a file named "([^"]+)" with (.*)/
     */
    public function iHaveAFileNamedWithInvalidData(FilePath $pathToFile, TableNode $table): void
    {
        $this->pathToFile = $pathToFile;
        $this->createCsvFileWithDataFromTable($this->pathToFile->path(), $table);

        Assert::assertFileExists($pathToFile->path());
    }

    /**
     * @Given There is an error in the system
     */
    public function thereIsAnErrorInTheSystem(): void
    {
        $path = $this->pathToFile->path();
        unlink($this->pathToFile->path());

        Assert::assertFileNotExists($path);
    }

    /**
     * @When I upload the file
     */
    public function iUploadTheFile(): void
    {
        try {
            $this->updatePricesFromUploadedFile->usingFile($this->pathToFile);
        } catch (Throwable $exception) {
            $this->lastException = $exception;
        }
    }

    /**
     * @Then A message is shown explaining the problem
     */
    public function aMessageIsShownExplainingTheProblem(PyStringNode $expectedMessage): void
    {
        $message = $this->lastException->getMessage();
        Assert::assertEquals($expectedMessage->getRaw(), $message);
    }

    /**
     * @Then /Changes are (not )?applied to the current prices/
     */
    public function changesAreAppliedOrNotToTheCurrentPrices(TableNode $productTable): void
    {
        $this->assertTheseProductsAreInTheRepository($productTable);
    }

    /** @Transform /([^"]+)/ */
    public function getFilePath(string $pathToFile): FilePath
    {
        $fullPathToFile = '/var/tmp/' . $pathToFile;
        touch($fullPathToFile);

        return new FilePath($fullPathToFile);
    }

    private function createCsvFileWithDataFromTable(string $path, TableNode $table): void
    {
        $file = fopen($path, 'wb');

        $header = true;
        foreach ($table as $row) {
            if ($header) {
                fputcsv($file, array_keys($row));
                $header = false;
            }
            fputcsv($file, $row);
        }
        fclose($file);
    }

    private function assertTheseProductsAreInTheRepository(TableNode $productTable): void
    {
        foreach ($productTable as $productRow) {
            $storedProduct = $this->productRepository->getById($productRow['id']);
            Assert::assertEquals($productRow['price'], $storedProduct->price());
        }
    }
}
