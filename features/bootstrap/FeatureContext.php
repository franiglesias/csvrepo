<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use TalkingBit\BddExample\FileReader\CSVFileReader;
use TalkingBit\BddExample\Persistence\InMemoryProductRepository;
use TalkingBit\BddExample\Product;
use TalkingBit\BddExample\ProductRepository;
use TalkingBit\BddExample\UpdatePricesFromUploadedFile;
use TalkingBit\BddExample\VO\FilePath;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var string */
    private $pathToFile;
    /** @var UpdatePricesFromUploadedFile */
    private $updatePricesFromUploadedFile;
    /** @var ProductRepository  */
    private $productRepository;

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
    public function thereAreCurrentPricesInTheSystem(TableNode $productTable)
    {
        foreach ($productTable as $productRow) {
            $product = new Product(
                $productRow['id'],
                $productRow['name'],
                $productRow['price']
            );
            $this->productRepository->store($product);
        }
    }

    /**
     * @Given I have a file named :pathToFile with the new prices
     */
    public function iHaveAFileNamedWithTheNewPrices(FilePath $pathToFile, TableNode $table)
    {
        $this->pathToFile = $pathToFile;
        $file = fopen($this->pathToFile->path(), 'w');

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

    /**
     * @When I upload the file
     */
    public function iUploadTheFile()
    {
        $this->updatePricesFromUploadedFile->usingFile($this->pathToFile);
    }

    /**
     * @Then Changes are applied to the current prices
     */
    public function changesAreAppliedToTheCurrentPrices(TableNode $productTable)
    {
        foreach ($productTable as $productRow) {
            $product = $this->productRepository->getById($productRow['id']);
            Assert::assertEquals($productRow['price'], $product->price());
        }
    }

    /**
     * @Given I have a file named :pathToFile with invalid data
     */
    public function iHaveAFileNamedWithInvalidData(FilePath $pathToFile, TableNode $table)
    {
        $this->pathToFile = $pathToFile;
        $file = fopen($this->pathToFile->path(), 'w');

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

    /**
     * @Then A message is shown explaining the problem
     */
    public function aMessageIsShownExplainingTheProblem()
    {
        throw new PendingException();
    }

    /**
     * @Then Changes are not applied to the current prices
     */
    public function changesAreNotAppliedToTheCurrentPrices()
    {
        throw new PendingException();
    }

    /**
     * @When There is an error in the system
     */
    public function thereIsAnErrorInTheSystem()
    {
        throw new PendingException();
    }

    /** @Transform :pathToFile */
    public function getFilePath(string $pathToFile): FilePath
    {
        return new FilePath('/var/tmp/' . $pathToFile);
    }
}
