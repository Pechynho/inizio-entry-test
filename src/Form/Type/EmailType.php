<?php


namespace App\Form\Type;


use App\Model\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("email", \Symfony\Component\Form\Extension\Core\Type\EmailType::class, [
			"label" => "E-mail"
		]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			"data_class" => Email::class
		]);
	}
}