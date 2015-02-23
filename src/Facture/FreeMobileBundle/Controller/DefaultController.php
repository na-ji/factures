<?php

namespace Facture\FreeMobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Sonata\PageBundle\Request\SiteRequest as Request;

use Facture\FreeMobileBundle\Entity\Contact;
use Facture\FreeMobileBundle\Entity\Appel;
use Facture\FreeMobileBundle\Entity\Data;
use Facture\FreeMobileBundle\Entity\MMS;
use Facture\FreeMobileBundle\Entity\SMS;

class DefaultController extends Controller
{
    public function importAction()
    {
		$file = file_get_contents('factures/facture_freemobile_20130628.htm');
		$facture_date = new \DateTime('2013-06-28');
		$em = $this->getDoctrine()->getManager();
		$repo_contact = $em->getRepository('FactureFreeMobileBundle:Contact');
		//ladybug_dump($file);
		
		preg_match_all('#<P class="p\d+ ft\d+"><NOBR>(.*?)<\/NOBR> (.*?)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">Voix \((.*?)\)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)<\/P><\/TD>#i', $file, $appels,  PREG_SET_ORDER );
		//preg_match_all('#<P class="p\d+ ft\d+">(.*?) (.*?)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">Voix \((.*?)\)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)<\/P><\/TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)<\/P><\/TD>#i', $file, $appels,  PREG_SET_ORDER );
		ladybug_dump($appels);
		
		preg_match_all('#<P class="p\d+ ft\d+"><NOBR>(.*?)</NOBR> (.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">SMS \((.*?)\)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>#i', $file, $sms, PREG_SET_ORDER);
		//preg_match_all('#<P class="p\d+ ft\d+">(.*?) (.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">SMS \((.*?)\)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>#i', $file, $sms, PREG_SET_ORDER);
		ladybug_dump($sms);
		
		preg_match_all('#<P class="p\d+ ft\d+"><NOBR>(.*?)</NOBR> (.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">MMS \((.*?)\)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">Kio</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>#i', $file, $mms, PREG_SET_ORDER);
		//preg_match_all('#<P class="p\d+ ft\d+">(.*?) (.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">MMS \((.*?)\)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">Kio</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>#i', $file, $mms, PREG_SET_ORDER);
		ladybug_dump($mms);
		
		//preg_match('#<TD colspan=2 class="tr6 td4"><P class="p2 ft9">Consommation Data</P></TD>\n	<TD class="tr6 td5"><P class="p7 ft9">(.*?)</P></TD>\n	<TD colspan=2 class="tr6 td6"><P class="p4 ft9">(.*?) \(<SPAN class="ft3">.*</SPAN>\)</P></TD>#i', $file, $data);
		preg_match('#<P class="p\d+ ft\d+">Consommation Data</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?)</P></TD>\n	<TD class="tr\d+ td\d+"><P class="p\d+ ft\d+">(.*?) \(<SPAN class="ft\d+">.*</SPAN>\)</P></TD>#i', $file, $data);
		ladybug_dump($data);
		
		if (count($appels) > 0)
		{
			$repo_appel = $em->getRepository('FactureFreeMobileBundle:Appel');
			foreach ($appels as $appel)
			{
				$heure = explode(':', $appel[2]);
				$date = new \DateTime(str_replace("/", "-", $appel[1]));
				$date->setTime($heure[0], $heure[1], $heure[2]);
				//ladybug_dump($date->format('Y-m-d H:i:s'));
				
				if (strpos($appel[5], "min"))
				{
					preg_match('#(.*?) min (.*?) s#', $appel[5], $duree);
					$duree = '00:'.str_pad($duree[1], 2, "0", STR_PAD_LEFT).':'.str_pad($duree[2], 2, "0", STR_PAD_LEFT);
				}
				else
				{
					$duree = '00:00:'.str_pad(substr($appel[5], 0, -2), 2, "0", STR_PAD_LEFT);
				}
				
				$duree = new \DateTime($duree);
				
				//ladybug_dump($appel[4].' : '.(!preg_match('#Messagerie#', $appel[4])).' | '.(!preg_match('#xxxx#i', $appel[4])));
				
				if (!preg_match('#Messagerie#', $appel[4]) && !preg_match('#xxxx#i', $appel[4]))
				{
					$appel[4] = substr($appel[4], 0, -4)."xxxx";
				}
				
				$contact = $repo_contact->findOneByNumero($appel[4]);
				//ladybug_dump($contact);
				
				if ($contact === null)
				{
					$contact = new Contact();
					$contact->setNom("Ano");
					$contact->setPrenom("Nymous");
					$contact->setNumero($appel[4]);
				}
				
				$call = new Appel();
				$call->setContact($contact);
				$call->setDate($date);
				$call->setOrigine($appel[3]);
				$call->setCout($appel[6]);
				$call->setDuree($duree);
				
				$em->persist($call);
				if ($contact->getId() === null)
				{
					ladybug_dump($contact);
					//$em->flush();
				}
				
				//ladybug_dump($call);
			}
		}
		
		if (count($sms) > 0)
		{
			$repo_sms = $em->getRepository('FactureFreeMobileBundle:SMS');
			foreach ($sms as $message)
			{
				$heure = explode(':', $message[2]);
				$date = new \DateTime(str_replace("/", "-", $message[1]));
				$date->setTime($heure[0], $heure[1], $heure[2]);
				//ladybug_dump($date->format('Y-m-d H:i:s'));
				
				//ladybug_dump($duree);				
				if (!preg_match('#xxxx#i', $message[4]))
				{
					$message[4] = substr($message[4], 0, -4)."xxxx";
				}
				$contact = $repo_contact->findOneByNumero($message[4]);
				//ladybug_dump($contact);
				
				if ($contact === null)
				{
					$contact = new Contact();
					$contact->setNom("Ano");
					$contact->setPrenom("Nymous");
					$contact->setNumero($message[4]);
				}
				
				$mess = new SMS();
				$mess->setContact($contact);
				$mess->setDate($date);
				$mess->setOrigine($message[3]);
				$mess->setCout($message[6]);
				$mess->setQuantite($message[5]);
				
				$em->persist($mess);
				if ($contact->getId() === null)
				{
					ladybug_dump($contact);
					//$em->flush();
				}
				
				//ladybug_dump($mess);
			}
		}
		
		if (count($mms) > 0)
		{
			$repo_mms = $em->getRepository('FactureFreeMobileBundle:MMS');
			foreach ($mms as $message)
			{
				$heure = explode(':', $message[2]);
				$date = new \DateTime(str_replace("/", "-", $message[1]));
				$date->setTime($heure[0], $heure[1], $heure[2]);
				//ladybug_dump($date->format('Y-m-d H:i:s'));
				
				//ladybug_dump($duree);				
				if (!preg_match('#xxxx#i', $message[4]))
				{
					$message[4] = substr($message[4], 0, -4)."xxxx";
				}
				$contact = $repo_contact->findOneByNumero($message[4]);
				//ladybug_dump($contact);
				
				if ($contact === null)
				{
					$contact = new Contact();
					$contact->setNom("Ano");
					$contact->setPrenom("Nymous");
					$contact->setNumero($message[4]);
				}
				
				$mess = new MMS();
				$mess->setContact($contact);
				$mess->setDate($date);
				$mess->setOrigine($message[3]);
				$mess->setCout($message[6]);
				$mess->setVolume(intval($message[5]) * 1000);
				
				$em->persist($mess);
				if ($contact->getId() === null)
				{
					ladybug_dump($contact);
					//$em->flush();
				}
				
				//ladybug_dump($mess);
			}
		}
		
		if (count($data) > 0)
		{
			$internet = new Data();
			$internet->setDate($facture_date);
			$internet->setConso(floatval( substr($data[1], 0, -4) ) * 1000000000);
			
			//$em->persist($internet);
			ladybug_dump($internet);
			
			//$em->flush();
		}
		
		//$em->flush();
		
		$response = new Response('<!DOCTYPE><html><head><meta charset="UTF-8"><title>test</title></head><body></body></html>');
		$response->headers->set('Charset', 'UTF-8');		

		return $response;
	}
	
	
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$repo_contact = $em->getRepository('FactureFreeMobileBundle:Contact');
		$repo_mms = $em->getRepository('FactureFreeMobileBundle:MMS');
		$repo_sms = $em->getRepository('FactureFreeMobileBundle:SMS');
		$repo_appel = $em->getRepository('FactureFreeMobileBundle:Appel');
		
        return $this->render('FactureFreeMobileBundle:Default:index.html.twig', array(
			'nb_contact'		=> $repo_contact->findContactNb()[0][1],
			'nb_sms'			=> $repo_sms->findSMSNb()[0][1],
			'nb_mms'			=> $repo_mms->findMMSNb()[0][1],
			'nb_appel'			=> $repo_appel->findAppelNb()[0][1],
		));
    }
    
    public function contactAction($page)
    {		
		$em = $this->getDoctrine()->getManager();
		$repo_contact = $em->getRepository('FactureFreeMobileBundle:Contact');
		$lady = $this->get('ladybug');
		
		$nb_page = ceil( intval($repo_contact->findContactNb()[0][1])/20 );
		$page = (intval($page) > $nb_page) ? 1 : intval($page);
		$page = ($page < 1) ? 1 : $page;
		
		$lady->log($nb_page);
		$lady->log($page);
		
        return $this->render('FactureFreeMobileBundle:Default:contacts.html.twig', array(
			'contacts'			=> $repo_contact->findBy(array(), array('id' => 'ASC'), 20, ($page-1)*20),
			'nb_page'			=> $nb_page,
			'page'				=> $page,
		));
    }
    
    public function chartsAction()
    {
		
	}
    
    public function contactProfileAction(Contact $contact)
    {		
		$em = $this->getDoctrine()->getManager();
		$repo_contact = $em->getRepository('FactureFreeMobileBundle:Contact');
		$repo_sms = $em->getRepository('FactureFreeMobileBundle:SMS');
		$repo_mms = $em->getRepository('FactureFreeMobileBundle:MMS');
		$repo_appel = $em->getRepository('FactureFreeMobileBundle:Appel');
		$lady = $this->get('ladybug');
		
		//$lady->log($repo_sms->findDateLastSMS($contact->getId())[0]['date']);
		$dates = array(
			"last_sms"			=> $repo_sms->findDateLastSMS($contact->getId()),
			"first_sms"			=> $repo_sms->findDateFirstSMS($contact->getId()),
			"last_mms"			=> $repo_mms->findDateLastMMS($contact->getId()),
			"first_mms"			=> $repo_mms->findDateFirstMMS($contact->getId()),
			"last_call"			=> $repo_appel->findDateLastCall($contact->getId()),
			"first_call"		=> $repo_appel->findDateFirstCall($contact->getId()),
		);
		
		$lady->log($dates);
		
		$appels = $repo_appel->findByContact($contact);
		$sum = new \DateTime();
		$sum->setTime(0, 0, 0);
		
		$zero = new \DateTime($sum->format('Y-m-d H:i:s'));
		
		$chart_appels = array();
		$chart_sms = array();
		$chart_mms = array();
		
		foreach ($appels as $appel)
		{
			$diff = $appel->getDuree()->diff($zero);
			$sum->sub( $diff );
			$chart_appels[] = array($appel->getDate()->getTimestamp()*1000, intval($diff->format('%s')) + (intval($diff->format('%i')) *60 ) + (intval($diff->format('%h'))*3600 ));
		}
		
		$sms = $repo_sms->findByContact($contact);
		
		foreach ($sms as $message)
		{
			$chart_sms[] = array($message->getDate()->getTimestamp()*1000, $message->getQuantite());
		}
		
		$mms = $repo_mms->findByContact($contact);
		
		$lady->log($chart_appels);
		
        return $this->render('FactureFreeMobileBundle:Default:profile.html.twig', array(
			"contact"			=> $contact,
			"sms"				=> $sms,
			"mms"				=> $mms,
			"appels"			=> $appels,
			"last_sms"			=> (count($dates["last_sms"]) > 0) ? $dates["last_sms"][0]['date'] : null,
			"first_sms"			=> (count($dates["first_sms"]) > 0) ? $dates["first_sms"][0]['date'] : null,
			"last_mms"			=> (count($dates["last_mms"]) > 0) ? $dates["last_mms"][0]['date'] : null,
			"first_mms"			=> (count($dates["first_mms"]) > 0) ? $dates["first_mms"][0]['date'] : null,
			"last_call"			=> (count($dates["last_call"]) > 0) ? $dates["last_call"][0]['date'] : null,
			"first_call"		=> (count($dates["first_call"]) > 0) ? $dates["first_call"][0]['date'] : null,
			"call_sum"			=> $sum,
			"chart_appels"		=> $chart_appels,
			"chart_sms"			=> $chart_sms,
		));
    }
}
