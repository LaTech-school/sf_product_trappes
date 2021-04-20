<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Product Name
            ->add('name', TextType::class, [

                // Label
                // --

                // Label text
                'label' => "Nom du produit",

                // Label Attributes
                'label_attr' => [
                    'class' => "",
                ],


                // Is required
                // --

                'required' => true,


                // Fields Attributes
                // --

                'attr' => [
                    'class' => "",
                    'placeholder' => "Saisir le nom du produit",
                ],


                // Helper
                // --

                'help' => "Le nom du produit sera affiché publiquement.",
                'help_attr' => [
                    'class' => "",
                ],


                // Constraints
                // --

                'constraints' => [
                    new NotBlank([
                        'message' => "Le nom du produit est obligatoire."
                    ])
                ],

            ])


            // Product Description
            ->add('description')


            // Product Price
            ->add('price')

            
            // Product Illustration
            // ->add('illustration')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
