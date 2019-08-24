<?php


namespace App\Form\Type;


use App\Model\SearchRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchRequestType extends AbstractType
{

	/**
	 * @inheritDoc
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add("ico", TextType::class, [
			"label" => "IČO"
		]);
	}

	/**
	 * @inheritDoc
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(["data_class" => SearchRequest::class]);
	}

}