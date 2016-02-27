<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/02/26
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\TodoStatus;
use AppBundle\Search\TodoList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\FormType()
 */
class TodoListType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TodoList::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'タイトル',
                'required' => false,
            ])
            ->add('status', 'choice',[
                'choices' => TodoStatus::getNames(),
                'label' => 'ステータス',
                'required' => false,
                'empty_value' => '選択してください'
            ]);

        // ステータスオブジェクトの変換
        $builder->get('status')->addModelTransformer(new CallbackTransformer(
                function ($output) {
                    if ($output instanceof TodoStatus) {
                        return $output->getValue();
                    }
                },
                function ($input) {
                    if (!empty($input)) {
                        return new TodoStatus($input);
                    }
                }
            ))
        ;

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'todo_list';
    }

}