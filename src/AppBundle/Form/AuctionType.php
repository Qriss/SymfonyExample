<?php
/**
 * Created by PhpStorm.
 * User: Qriss
 * Date: 14.01.2018
 * Time: 12:07
 */
namespace AppBundle\Form;

use AppBundle\Entity\Auction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuctionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, ['label'=> "tytuł"])
            ->add("description", TextareaType::class, ['label'=> "opis"])
            ->add("price", NumberType::class, ['label'=> "Cena"])
            ->add("startingPrice", NumberType::class, ['label'=> "Cena wywolawcza"])
            ->add("expiresAt", DateTimeType::class, ['label'=> "Data zakonczenia",
                "data" => new\DateTime("+ 1 day + 10 minutes")])
            ->add("submit", SubmitType::class, ['label'=> "Zapisz"]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Auction::class]);
    }
}