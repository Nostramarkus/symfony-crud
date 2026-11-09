<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ProductInput
{
    #[Assert\Sequentially([
        new Assert\NotBlank(message: 'Naam is verplicht.'),
        new Assert\Type('string', message: 'Naam moet tekst zijn.')
    ])]
    public mixed $name = null;

    #[Assert\Sequentially([
        new Assert\NotNull(message: 'Prijs is verplicht.'),
        new Assert\Type('integer', message: 'Prijs moet een geheel getal zijn.'),
        new Assert\PositiveOrZero(message: 'Prijs mag niet negatief zijn.')
    ])]
    public mixed $priceInCents = null;

    #[Assert\Sequentially([
        new Assert\NotNull(message: 'Voorraad is verplicht.'),
        new Assert\Type('integer', message: 'Voorraad moet een geheel getal zijn.'),
        new Assert\PositiveOrZero(message: 'Voorraad mag niet negatief zijn.')
    ])]
    public mixed $stock = null;
}
