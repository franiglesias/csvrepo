<?php

namespace TalkingBit\BddExample;

use InvalidArgumentException;
use RuntimeException;
use TalkingBit\BddExample\FileReader\FileReader;
use TalkingBit\BddExample\VO\FilePath;

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

    public function usingFile(FilePath $pathToFile)
    {
        $data = $this->fileReader->readFrom($pathToFile);
        foreach ($data as $row) {
            $product = $this->productRepository->getById($row['product_id']);
            $product->setPrice($row['new_price']);
        }
    }
}
