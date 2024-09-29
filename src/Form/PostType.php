<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use App\Entity\Post;
use App\Form\Type\DateTimePickerType;
use App\Form\Type\TagsInputType;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Defines the form used to create and manipulate blog posts.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
final class PostType extends AbstractType
{
    // Form types are services, so you can inject other services in them if needed
    public function __construct(
        private readonly SluggerInterface $slugger
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // For the full reference of options defined by each form field type
        // see https://symfony.com/doc/current/reference/forms/types.html

        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('title', null, ['required' => false, ...]);

        $builder
            ->add('title', null, [
                'label' => 'label.title',
            ])
            ->add('content', null, [
                'attr' => ['rows' => 10],
                'help' => 'help.post_content',
                'label' => 'label.content',
            ])
            ->add('gender',ChoiceType::class,
            [
                'label' => 'label.gender',
                'required' => true,
                'choices'=>["label.gender.choice"=>null,'M'=>'M',"F"=>"F"]

            ]
            )
            ->add('width', NumberType::class, [
                'label' => 'label.width',
                'attr'     => array(
                    'min'  => 200,
                    'max'  => 1000,
                    'step' => 10,
                ),
            ])
            ->add('weight',NumberType::class, ['label' => 'label.weight'])
            ->add('street',null, [
                'required' => false
            ])
            ->add('city',null, [
                'label' => 'label.city',
                'required' => false
            ])
            ->add('name',null, [
                'label' => 'label.name',
                'attr' => ['autofocus' => true],
                'required' => true
            ])
            ->add('zip', null, [
                'label' => 'label.zip',
                'required' => false
            ])
            ->add('country', CountryType::class,
            [
                'label' => 'label.country',
            ]
            )
            ->add('publishedAt', DateTimePickerType::class, [
                'label' => 'label.published_at',
                'help' => 'help.post_publication',
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'label.image',
                "mapped"=>false,
                'attr' => [
                    'accept' => "image/*"
                ],
                'constraints' => [
                    new Image()
                ]
            ])

            // form events let you modify information or fields at different steps
            // of the form handling process.
            // See https://symfony.com/doc/current/form/events.html
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                /** @var Post $post */
                $post = $event->getData();
                if (null === $post->getSlug() && null !== $post->getName()) {
                    $post->setSlug($this->slugger->slug($post->getName())->lower());
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'csrf_protection' => true,
            'csrf_field_name' => 'token',
            'csrf_token_id'   => 'add-new-post'

        ]);
    }
}
