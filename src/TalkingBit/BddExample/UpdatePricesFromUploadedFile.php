<?php

namespace TalkingBit\BddExample;

use TalkingBit\BddExample\FileReader\FileReader;
use TalkingBit\BddExample\VO\FilePath;
use UnexpectedValueException;

class UpdatePricesFromUploadedFile
{
    /** @var FileReader */
    private $fileReader;
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository, FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
        $this->productRepository = $productRepository;
    }

    public function usingFile(FilePath $pathToFile): void
    {
        $data = $this->fileReader->readFrom($pathToFile);
        foreach ($data as $row) {
            $this->checkIsAValidDataStructure($row);
            $product = $this->productRepository->getById($row['product_id']);
            $product->setPrice($row['new_price']);
        }
    }

    private function checkIsAValidDataStructure($row): void
    {
        if (! isset($row['product_id']) || ! isset($row['new_price'])) {
            throw new UnexpectedValueException('The file doesn\'t contain valid data to update prices');
        }
    }
}
