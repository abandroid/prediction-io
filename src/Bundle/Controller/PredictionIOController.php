<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\PredictionIO\Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Endroid\PredictionIO\EngineClient;
use Endroid\PredictionIO\EventClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class PredictionIOController extends Controller
{
    /**
     * @Route("/", name="endroid_predictionio_index")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        // Disable web profiler when using React
        if ($this->has('profiler')) {
            $this->get('profiler')->disable();
        }

        return [];
    }

    /**
     * @Route("/state", name="endroid_predictionio_state")
     *
     * @return Response
     */
    public function stateAction()
    {
        $users = [];
        $items = [];
        $recommendations = [];

        for ($n = 0; $n < 10; ++$n) {
            $users[] = [
                'id' => 'U'.$n,
                'recommendations' => $this->getRecommendationEngineClient()->getRecommendedItems('U'.$n, 5)
            ];
            $products[] = [
                'id' => 'I'.$n,
                'similar' => []
            ];
        }

        return new JsonResponse([
            'users' => $users,
            'items' => $items,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * @Route("/initialize", name="endroid_predictionio_initialize")
     *
     * @return Response
     */
    public function initializeAction()
    {
        for ($n = 0; $n < 10; ++$n) {
            $this->getEventClient()->createUser('U'.$n, ['age' => 20 + $n, 'gender' => 'M']);
            $this->getEventClient()->createItem('I'.$n, ['itypes' => [1]]);
        }

        return new JsonResponse();
    }

    /**
     * @Route("/view/{userId}/{itemId}", name="endroid_predictionio_view")
     *
     * @param string $userId
     * @param string $itemId
     * @return Response
     */
    public function viewAction($userId, $itemId)
    {
        $this->getEventClient()->recordUserActionOnItem('view', $userId, $itemId);

        return new JsonResponse();
    }

    /**
     * @Route("/purchase/{userId}/{itemId}", name="endroid_predictionio_purchase")
     *
     * @param string $userId
     * @param string $itemId
     * @return Response
     */
    public function purchaseAction($userId, $itemId)
    {
        $this->getEventClient()->recordUserActionOnItem('purchase', $userId, $itemId);

        return new JsonResponse();
    }

    /**
     * @return EventClient
     */
    protected function getEventClient()
    {
        return $this->get('endroid.prediction_io.endroid.event_client');
    }

    /**
     * @return EngineClient
     */
    protected function getRecommendationEngineClient()
    {
        return $this->get('endroid.prediction_io.endroid.recommendation.engine_client');
    }
}
