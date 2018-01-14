<?php
/**
 * Created by PhpStorm.
 * User: Qriss
 * Date: 14.01.2018
 * Time: 18:17
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Auction;
use AppBundle\Entity\Offer;
use AppBundle\Form\BidType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OfferController extends Controller
{
    /**
     * @Route("/auction/buy/{id}", name="offer_buy", methods = {"POST"})
     *
     * @param Auction $auction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function buyAction(Auction $auction)
    {
        $offer = new Offer();
        $offer->setAuction($auction)
            ->setType(Offer::TYPE_BUY)
            ->setPrice($auction->getPrice());

        $auction->setStatus(Auction::STATUS_FINISHED)
        ->setExpiresAt(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($auction);
        $entityManager->persist($offer);
        $entityManager->flush();

        $this->addFlash("success", "Kupiles przedmiot {$auction->getTitle()} za kwote {$offer->getPrice()} zl");

        return $this->redirectToRoute("auction_details", ["id"=> $auction->getId()]);
    }

    /**
     * @Route("/auction/bid/{id}", name="offer_bid", methods = {"POST"})
     * @param Request $request
     * @param Auction $auction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function bidAction(Request $request, Auction $auction)
    {
        $offer = new Offer();

        $bidForm = $this->createForm(BidType::class, $offer);
        $bidForm->handleRequest($request);



        if($bidForm->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $lastOffer = $entityManager->getRepository(Offer::class)->findOneBy(["auction"=> $auction], ["createAt" =>"DESC"]);

            if(isset($lastOffer))
            {
                if($offer->getPrice() <= $lastOffer->getPrice()){
                    $this->addFlash("error",
                        "Twoja oferta nie moze byc nizsza niz {$lastOffer->getPrice()}zl");
                    return $this->redirectToRoute("auction_details", ["id"=> $auction->getId()]);
                }
            } else {
                if($offer->getPrice() < $auction->getStartingPrice()){
                    $this->addFlash("error",
                        "Twoja oferta nie moze byc nizsza od ceny wywolawczej");
                    return $this->redirectToRoute("auction_details", ["id"=> $auction->getId()]);
                }
            }

            $offer->setType(Offer::TYPE_BID)
                ->setAuction($auction);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            $this->addFlash("success",
                "Zlozyles oferte na przedmiot {$auction->getTitle()} za kwote {$offer->getPrice()} zl");

        } else{
            $this->addFlash("error",
                "Nie udalo sie zalicytowac");
        }


        return $this->redirectToRoute("auction_details", ["id"=> $auction->getId()]);
    }

}