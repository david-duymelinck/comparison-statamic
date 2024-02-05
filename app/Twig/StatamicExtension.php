<?php

namespace App\Twig;

use Statamic\Facades\Asset;
use Statamic\Fieldtypes\Bard;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Statamic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class StatamicExtension extends AbstractExtension
{

    public function getName()
    {
        return 'StatamicExtension';
    }
    public function getFilters()
    {
        return [
            new TwigFilter('glide', $this->glide(...)),
            new TwigFilter('bardHtml', $this->bardHtml(...)),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getForm', $this->getForm(...)),
            new TwigFunction('getAsset', $this->getAsset(...)),
            new TwigFunction('getNav', $this->getNav(...)),
            ];
    }

    public function getTokenParsers()
    {
        return [
            new SwitchTokenParser()
            ];
    }

    public function glide(string $src, array $settings)
    {
        $glide = Statamic::tag('glide:generate')->src($src);

        foreach($settings as $key => $value) {
            if($key === 'width') {
                $glide->width($value);
            }
        }

        $glide = $glide->fetch();

        return $glide[0]['url'] ?? $src;
    }

    public function getForm(string $handle) {
        $form = Statamic::tag('form:create')->in($handle)->fetch();

        $form['fields'][] = [
          'handle' => '_token',
          'hide_display' => true,
          'display' => 'csrf token',
          'value' => csrf_token(),
          'input' => csrf_field()
        ];

        return $form;
    }

    public function bardHtml($content) {
        if(!isset($content['content'])) {
            $content = ['content' => $content];
        }

        return (new Augmentor(new Bard()))->convertToHtml($content);
    }

    public function getAsset($url) {
        $asset = Statamic::tag('asset')->url($url)->fetch();

        return $asset;
    }

    public function getNav($handle) {
        $nav = Statamic::tag('nav')->handle($handle)->fetch();

        return $nav;
    }
}
