<?php

namespace GYGB\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommunityController extends Controller
{
    public function communityAction()
    {
        return $this->forward('GYGBFrontBundle:Community:communitySteps');
    }
    
    public function communityMapAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $stepSubmissions = $stepSubmissionRepository->findAllApproved();
                
        return $this->render('GYGBFrontBundle:Community:_communityMap.html.twig', array(
            'stepSubmissions' => $stepSubmissions,
        ));
    }
    
    public function communityVideosAction($id = null)
    {                
        $videos = array (
            array('id' => 'CKHanWS2jN4'),
            array('id' => 'rJ9ZGP0Vmow'),
        );

        
        if(!isset($id)) {
            $id = $videos[0]['id'];
        }
        
        try {
            //\Zend_Loader::loadClass('Zend_Gdata_YouTube');

       //     $yt = new \Zend_Gdata_YouTube();
        //    $videoEntry = $yt->getFullVideoEntry($id);
        //    $this->printVideoEntry($videoEntry);
        } catch (Exception $e) {
            print_r($e);
        }
        
        return $this->render('GYGBFrontBundle:Community:_communityVideos.html.twig', array(
            'videos' => $videos,
            'currentVideo' => $id
        ));
    }
    
    public function printVideoEntry($videoEntry) 
    {
        // the videoEntry object contains many helper functions
        // that access the underlying mediaGroup object
        echo 'Video: ' . $videoEntry->getVideoTitle() . "\n";
        echo 'Video ID: ' . $videoEntry->getVideoId() . "\n";
        echo 'Updated: ' . $videoEntry->getUpdated() . "\n";
        echo 'Description: ' . $videoEntry->getVideoDescription() . "\n";
        echo 'Category: ' . $videoEntry->getVideoCategory() . "\n";
        echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "\n";
        echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "\n";
        echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "\n";
        echo 'Duration: ' . $videoEntry->getVideoDuration() . "\n";
        echo 'View count: ' . $videoEntry->getVideoViewCount() . "\n";
        echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "\n";
        echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "\n";
        echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "\n";

        // see the paragraph above this function for more information on the 
        // 'mediaGroup' object. in the following code, we use the mediaGroup
        // object directly to retrieve its 'Mobile RSTP link' child
        foreach ($videoEntry->mediaGroup->content as $content) {
            if ($content->type === "video/3gpp") {
                echo 'Mobile RTSP link: ' . $content->url . "\n";
            }
        }

        echo "Thumbnails:\n";
        $videoThumbnails = $videoEntry->getVideoThumbnails();

        foreach($videoThumbnails as $videoThumbnail) {
            echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
            echo ' height=' . $videoThumbnail['height'];
            echo ' width=' . $videoThumbnail['width'] . "\n";
        }
    }
    
    /*
     *  public function getAuthSubRequestUrl()
    {
        $next = 'http://localhost:8888/GYGB/web/app_dev.php/share-a-step';
        $scope = 'http://gdata.youtube.com';
        $secure = false;
        $session = true;
        return \Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
    }

            if (!isset($_SESSION['sessionToken']) && !isset($_GET['token']) ){
            echo '<a href="' . $this->getAuthSubRequestUrl() . '">Login!</a>';
        } else if (!isset($_SESSION['sessionToken']) && isset($_GET['token'])) {
            $_SESSION['sessionToken'] = \Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
            echo $_GET['token'].'<br/>';
            echo $_SESSION['sessionToken'];
        }

        //$httpClient = \Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);

        

     */
    
    public function communityStepsAction()
    {
        $stepSubmissionRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:StepSubmission');
        $stepSubmissions = $stepSubmissionRepository->findApprovedAndFeatured();
        
        return $this->render('GYGBFrontBundle:Community:_communitySteps.html.twig', array(
            'stepSubmissions' => $stepSubmissions,
        ));
    }

    public function stepsTakenCounterAction($extendLayout = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepTotals = $stepRepository->findCategoryStepSubmissionTotals();
        
        $count = $stepTotals['all'];
        $counterDigits = $this->buildCounterDigits($count);
        
        return $this->render('GYGBFrontBundle:Community:_counter.html.twig', array(
            'counterDigits' => $counterDigits,
            'text' => 'Steps Taken',
            'id' => 'steps-taken'
        ));
    }
    
    public function commitmentsMadeCounterAction($extendLayout = false)
    {
        $stepRepository = $this->getDoctrine()->getRepository('GYGBBackBundle:Step');
        $stepTotals = $stepRepository->findCategoryCommitmentsTotals();
        
        $count = $stepTotals['all'];
        $counterDigits = $this->buildCounterDigits($count);
        
        return $this->render('GYGBFrontBundle:Community:_counter.html.twig', array(
            'counterDigits' => $counterDigits,
            'text' => 'Commitments Made',
            'id' => 'commitments-made'
        ));
    }
    
    protected function buildCounterDigits($count)
    {
        $count = (int) $count;
        $count = (string) $count;
        $counterDigits = array();

        for($i = 0; $i < strlen($count); $i++)
        {
            $counterDigits[] = $count[$i];
        }
        
        return $counterDigits;
    }


}
