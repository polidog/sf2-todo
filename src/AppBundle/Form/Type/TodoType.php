<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 2:33
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Todo;
use AppBundle\Entity\TodoStatus;
use Symfony\Component\Form\AbstractType;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TodoType
 * @package AppBundle\Form\Type
 *
 * @DI\FormType()
 */
class TodoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Todo::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', [
            'label' => false,
            'required' => true,
        ]);
    }

    public function getName()
    {
        return 'todo';
    }

}