<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigImagePathExt extends AbstractExtension
{

 private string $projectDir;

public function __construct(
    #[Autowire('%kernel.project_dir%')]  string $projectDir
)
{

    //$this->projectDir = str_replace('\\', '/', $projectDir).'/public/uploads/images/';
    $this->projectDir = '/uploads/image/';

}


    public function getFilters(): array
    {
        return [
            new TwigFilter('imagePath', [$this, 'getImagePath']),
        ];
    }

    public function getImagePath(?string $source, string $type=null): ?string
    {


        if(empty($source)){
            return null;
        }
        if($type and $type =='small'){
            if(file_exists($this->projectDir."small_".$source)){
                return $this->projectDir."small_".$source;
            }

        }

        return $this->projectDir.$source;
    }

}