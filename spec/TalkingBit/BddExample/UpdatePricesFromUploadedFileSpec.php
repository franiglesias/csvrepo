<?php

namespace spec\TalkingBit\BddExample;

use PhpSpec\ObjectBehavior;
use Prophecy\Prophet;
use RuntimeException;
use TalkingBit\BddExample\FileReader\FileReader;
use TalkingBit\BddExample\ProductRepository;
use TalkingBit\BddExample\Product;
use TalkingBit\BddExample\UpdatePricesFromUploadedFile;
use TalkingBit\BddExample\VO\FilePath;

class UpdatePricesFromUploadedFileSpec extends ObjectBehavior
{
    public function let(ProductRepository $productRepository, FileReader $fileReader, FilePath $filePath): void
    {
        $fileReader->readFrom($filePath)->willReturn([]);
        $this->beConstructedWith($productRepository, $fileReader);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UpdatePricesFromUploadedFile::class);
    }

    public function it_should_receieve_a_path_to_a_file(FilePath $filePath): void
    {
        $this->usingFile($filePath);
    }

    public function it_should_fail_if_file_is_empty(FileReader $fileReader, FilePath $filePath): void
    {
        $fileReader->readFrom($filePath)->willThrow(RuntimeException::class);
        $this->shouldThrow(RuntimeException::class)
             ->during('usingFile', [$filePath]);
    }

    public function it_should_update_prices_for_the_products_in_file(
        ProductRepository $productRepository,
        Product $product,
        FileReader $fileReader,
        FilePath $filePath
    ): void {
        $fileReader
            ->readFrom($filePath)
            ->willReturn(
                [
                    ['product_id' => 101, 'new_price' => 14.50]
                ]
            );
        $product->setPrice(14.50)->shouldBeCalled();

        $productRepository->getById(101)->shouldBeCalled()->willReturn($product);

        $this->usingFile($filePath);
    }
}
