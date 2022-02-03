<?php

namespace FruitBasket\Infrastructure\Http\Controller;

use FruitBasket\Infrastructure\Dto\BaseDto;
use FruitBasket\Infrastructure\Dto\UpdateBasketDto;
use FruitBasket\Infrastructure\Dto\UpdateBasketItemsDto;
use FruitBasket\Infrastructure\Dto\CreateBasketDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use FruitBasket\Infrastructure\Service\BasketService;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class PostController
 * @package App\Controller
 * @Route("/api", name="basket_api")s
 */
class BasketController extends AbstractController
{
    private ValidatorInterface $validator;
    private BasketService $basketService;
    private NormalizerInterface $normalizer;

    public function __construct(
        ValidatorInterface $validator,
        BasketService $basketService,
        NormalizerInterface $normalizer
    ) {
        $this->validator = $validator;
        $this->basketService = $basketService;
        $this->normalizer = $normalizer;
    }
    /**
     * Get list of baskets
     * @return JsonResponse
     * @Route("/baskets", name="basket_list", methods={"GET"})
     */
    public function getBaskets()
    {
        return $this->json($this->normalizer->normalize(
            $this->basketService->getBaskets(),
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'maxCapacity'
                ]
            ]
        ));
    }

    /**
     * Get basket details
     * @return JsonResponse
     * @Route("/baskets/{id}", name="basket_item", methods={"GET"})
     */
    public function getBasket(int $id)
    {
        return $this->json($this->normalizer->normalize(
            $this->basketService->getBasket($id),
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'maxCapacity'
                ]
            ]
        ));
    }

    /**
     * Get Basket Items
     * @param int $id
     * @return JsonResponse
     * @Route("/baskets/{id}/items", name="basket_items", methods={"GET"})
     */
    public function getBasketsItems(int $id)
    {
        $basket = $this->basketService->getBasket($id);

        return $this->json($this->normalizer->normalize(
            $basket,
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'items' => [
                        'id',
                        'type',
                        'weight'
                    ]
                ]
            ]
        ));
    }


    /**
     * Create Basket
     * @param Request $request
     * @return JsonResponse
     * @Route("/baskets", name="basket_create", methods={"POST"})
     */
    public function createBasket(Request $request)
    {
        $createBasketDto = $this->populateDto($request, CreateBasketDto::class);
        $errors = $this->validate($createBasketDto);
        if (count($errors) > 0) {
            return $this->json(['errros' => $errors], 400);
        }
        $basket = $this->basketService->createBasket($createBasketDto);

        return $this->json($this->normalizer->normalize(
            $basket,
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'maxCapacity'
                ]
            ]
        ));
    }


    /**
     * Update Basket Name
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @Route("/baskets/{id}", name="basket_update", methods={"PUT"})
     */
    public function updateBasket(Request $request, $id)
    {
        $updateBasketDto = $this->populateDto($request, UpdateBasketDto::class);
        $errors = $this->validate($updateBasketDto);
        if (count($errors) > 0) {
            return $this->json(['errros' => $errors], 400);
        }
        $basket = $this->basketService->updateBasket($id, $updateBasketDto);

        return $this->json($this->normalizer->normalize(
            $basket,
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'maxCapacity'
                ]
            ]
        ));
    }

    /**
     * Add Basket Items
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @Route("/baskets/{id}/items", name="basket_items_add", methods={"POST"})
     */
    public function addBasketItems(Request $request, $id)
    {
        $updateBasketItemsDto = $this->populateDto($request, UpdateBasketItemsDto::class);
        $errors = $this->validate($updateBasketItemsDto);
        if (count($errors) > 0) {
            return $this->json(['errros' => $errors], 400);
        }
        $basket = $this->basketService->addItems($id, $updateBasketItemsDto);

        return $this->json($this->normalizer->normalize(
            $basket,
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'items' => [
                        'id',
                        'type',
                        'weight'
                    ]
                ]
            ]
        ));
    }


    /**
     * Remove Basket Items
     * @param int $id
     * @return JsonResponse
     * @Route("/baskets/{id}/items", name="basket_items_remove", methods={"DELETE"})
     */
    public function removeBasketItems($id)
    {
        $basket = $this->basketService->removeBasketItems($id);

        return $this->json($this->normalizer->normalize(
            $basket,
            'json',
            [
                AbstractNormalizer::ATTRIBUTES => [
                    'id',
                    'name',
                    'maxCapacity'
                ]
            ]
        ));
    }

    /**
     * Remove Basket
     * @param int $id
     * @return JsonResponse
     * @Route("/baskets/{id}", name="basket_remove", methods={"DELETE"})
     */
    public function removeBasket($id)
    {
        $this->basketService->removeBasket($id);
        return $this->json([
            'message' => 'OK'
        ]);
    }



    public function populateDto(Request $request, $dtoClass): BaseDto
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Wrong body input format');
        }
        return $dtoClass::fromArray($data);
    }

    public function validate(BaseDto $dto)
    {
        $errors = $this->validator->validate($dto);
        $errorMessages = [];
        if (count($errors) > 0) {
            foreach ($errors as $message) {
                $errorMessages[] = [
                    'property' => $message->getPropertyPath(),
                    'value' => $message->getInvalidValue(),
                    'message' => $message->getMessage(),
                ];
            }
        }
        return $errorMessages;
    }
}
