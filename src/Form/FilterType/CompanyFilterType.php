<?php


namespace App\Form\FilterType;


use App\Entity\Main\Company;
use DateTime;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateTimeRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyFilterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add("name", TextFilterType::class, [
				"label"             => "Název subjektu",
				"condition_pattern" => FilterOperands::STRING_CONTAINS
			])
			->add("searched", DateTimeRangeFilterType::class, [
				"left_datetime_options"  => [
					"label"  => "Vyhledáno od",
					"attr"   => [
						"data-toggle" => "datetime-picker",
						"placeholder" => "Např. 31.02.2012 05:05",
					],
					"html5"  => false,
					"widget" => "single_text",
					"format" => "dd.MM.yyyy kk:mm"
				],
				"right_datetime_options" => [
					"label"  => "Vyhledáno do",
					"attr"   => [
						"data-toggle" => "datetime-picker",
						"placeholder" => "Např. 31.02.2012 05:05",
					],
					"html5"  => false,
					"widget" => "single_text",
					"format" => "dd.MM.yyyy kk:mm"
				],
				"apply_filter"           => function (QueryInterface $filterQuery, $field, $values) {
					if (empty($values["value"]))
					{
						return null;
					}
					$arguments = [["left_datetime", ">=", 0], ["right_datetime", "<=", 59]];
					/** @var QueryBuilder $queryBuilder */
					$queryBuilder = $filterQuery->getQueryBuilder();
					foreach ($arguments as $key => $argument)
					{
						if(empty($values["value"][$argument[0]]) || empty($values["value"][$argument[0]][0]))
						{
							continue;
						}
						/** @var DateTime $datetime */
						$datetime = $values["value"][$argument[0]][0];
						$clone = clone($datetime);
						$clone->setTime($datetime->format("H"), $datetime->format("i"), $argument[2]);
						$parameterName = $argument[0] . "_" . $key;
						$queryBuilder->andWhere("$field " . $argument[1] . " :$parameterName")->setParameter($parameterName, $clone);
					}
				}
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			"data_class"      => Company::class,
			"method"          => "GET",
			"csrf_protection" => false
		]);
	}

}