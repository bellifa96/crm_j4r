<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\Interlocuteur\Societe;
use App\Form\Ged\FichierType;
use App\Form\Interlocuteur\InterlocuteurType;
use App\Repository\DemandeRepository;
use App\Repository\Ged\FichierRepository;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/interlocuteur/interlocuteur')]
class InterlocuteurController extends AbstractController
{
    #[Route('/', name: 'app_interlocuteur_interlocuteur_index', methods: ['GET'])]
    public function index(InterlocuteurRepository $interlocuteurRepository,UserRepository $userRepository): Response
    {

        $data = [
            ["user" => "", "societe" => "59 b rue de la Chapelle -Paris", 'nchantier' => "21184", "statut" => "En attente OS", "ville" => "PARIS 18", "cp" => "75", "adresse" => "59b rue de la Chapelle", "nomChantier" => "59b rue de la Chapelle -Paris", "date" => "44713"],
            ["user" => "JEREMY", "societe" => "ENEDIS", 'nchantier' => "21185", "statut" => "En attente OS", "ville" => "PARIS", "cp" => "75005", "adresse" => "2 cité du Cardinal Lemoine", "nomChantier" => "ENEDIS", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Mr TORCHUT", 'nchantier' => "21186", "statut" => "A démarrer", "ville" => "MONTESSON", "cp" => "78", "adresse" => "11 avenue Jules Verne - Lot B", "nomChantier" => "Mr TORCHUT", "date" => ""],
            ["user" => "J.F", "societe" => "Vincennes", 'nchantier' => "21187", "statut" => "A démarrer", "ville" => "VINCENNES", "cp" => "94", "adresse" => "2, 4 avenue Paul Deroulede", "nomChantier" => "Vincennes", "date" => "44531"],
            ["user" => "06 26 56 37 23", "societe" => "Plessis", 'nchantier' => "21188", "statut" => "En attente OS", "ville" => "LE PLESSIS TREVISE", "cp" => "94420", "adresse" => "36 Rue de chennevieres", "nomChantier" => "Plessis", "date" => ""],
            ["user" => "JEREMY", "societe" => "Asnière", 'nchantier' => "21189", "statut" => "A démarrer", "ville" => "ASNIERES-SUR-SEINE", "cp" => "92", "adresse" => "7b à 11, rue Adolphe Briffault - 97 à 99 rue Gilbert Rousset", "nomChantier" => "Asnière", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "High Garden", 'nchantier' => "21190", "statut" => "En attente OS", "ville" => "ROSNY SOUS BOIS", "cp" => "93", "adresse" => "Rue de Lisbonne", "nomChantier" => "High Garden", "date" => ""],
            ["user" => "DAVID", "societe" => "CAFE DES CASCADEURS", 'nchantier' => "21191", "statut" => "En attente OS", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "ZAC Coteaux Beauclair / Lot C2", "nomChantier" => "CAFE DES CASCADEURS", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Fédération Française de Canoë Kayak et Sports de Pagaie", 'nchantier' => "21192", "statut" => "En attente OS", "ville" => "VAIRES SUR MARNE", "cp" => "77", "adresse" => "PAC DISNEYLAND PARIS", "nomChantier" => "Fédération Française de Canoë Kayak et Sports de Pagaie", "date" => ""],
            ["user" => "DAVID", "societe" => "CRECHE DEPARTEMENTALE DU GRAND ENSEMBLE", 'nchantier' => "21193", "statut" => "A démarrer", "ville" => "ALFORTVILLE", "cp" => "94", "adresse" => "Base Nautique Olympique, Route de Torcy, 77360", "nomChantier" => "CRECHE DEPARTEMENTALE DU GRAND ENSEMBLE", "date" => "44522"],
            ["user" => "06 73 87 85 52", "societe" => "L'allée des Champs", 'nchantier' => "21194", "statut" => "En attente OS", "ville" => "CHAMPS-SUR-MARNE", "cp" => "77", "adresse" => "Place du 11 Novembre", "nomChantier" => "L'allée des Champs", "date" => "44682"],
            ["user" => "DAVID", "societe" => "Paris 4", 'nchantier' => "21195", "statut" => "A démarrer", "ville" => "PARIS 4", "cp" => "75", "adresse" => "105-109, boulevard de la République", "nomChantier" => "Paris 4", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "SCI CDS Company", 'nchantier' => "21196", "statut" => "A démarrer", "ville" => "HOUILLES", "cp" => "78", "adresse" => "41 rue du Temple", "nomChantier" => "SCI CDS Company", "date" => "44531"],
            ["user" => "JEREMY", "societe" => "Hôtel", 'nchantier' => "21197", "statut" => "A démarrer", "ville" => "MONTEVRAIN", "cp" => "77", "adresse" => "13 rue de Verdun - Lot B", "nomChantier" => "Hôtel", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Paris 8", 'nchantier' => "21198", "statut" => "A démarrer", "ville" => "PARIS 8", "cp" => "75", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "nomChantier" => "Paris 8", "date" => "44536"],
            ["user" => "QUENTIN", "societe" => "Bondy", 'nchantier' => "21199", "statut" => "En attente OS", "ville" => "BONDY", "cp" => "93", "adresse" => "14 Rue Royale", "nomChantier" => "Bondy", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "Livry", 'nchantier' => "21200", "statut" => "A démarrer", "ville" => "LIVRY SUR SEINE", "cp" => "77", "adresse" => "60  Avenue du Maréchal de Lattre de Tassigny", "nomChantier" => "Livry", "date" => ""],
            ["user" => "QUENTIN", "societe" => "Alguésens/Semapa", 'nchantier' => "21201", "statut" => "En attente OS", "ville" => "PARIS 13", "cp" => "75", "adresse" => "27 Rue du Four à Chaux", "nomChantier" => "Alguésens/Semapa", "date" => "44927"],
            ["user" => "07 88 11 83 09", "societe" => "Les Ateliers Dajot", 'nchantier' => "21202", "statut" => "En attente OS", "ville" => "MELUN", "cp" => "77", "adresse" => "Rue Jean Antoine de Baif / Allée Paris-Ivry / Boulevard du Général d'Armée Jean Simon", "nomChantier" => "Les Ateliers Dajot", "date" => "44559"],
            ["user" => "QUENTIN", "societe" => "SERVICES MUNICIPAUX", 'nchantier' => "21203", "statut" => "A démarrer", "ville" => "LE KREMLIN BICETRE", "cp" => "94", "adresse" => "4 rue Dajot", "nomChantier" => "SERVICES MUNICIPAUX", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "Rhapsody in blue", 'nchantier' => "21204", "statut" => "En attente OS", "ville" => "CHESSY", "cp" => "77", "adresse" => "10 Rue Etienne Dolet", "nomChantier" => "Rhapsody in blue", "date" => "44866"],
            ["user" => "DAVID", "societe" => "Pirates des Caraibes (Disney)", 'nchantier' => "21205", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "Lot AF4A19 / Quartier des Studios et Congrès", "nomChantier" => "Pirates des Caraibes (Disney)", "date" => "44256"],
            ["user" => "06 73 87 85 52", "societe" => "Juvisy Sur Orge III 91", 'nchantier' => "21206", "statut" => "En attente OS", "ville" => "JUVISY SUR ORGE", "cp" => "91", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "Juvisy Sur Orge III 91", "date" => "intervention 1er trimestre 2023"],
            ["user" => "J.F ", "societe" => "Maison individuelle Mr PETIZON Laurent", 'nchantier' => "21207", "statut" => "A démarrer", "ville" => "CLAIREFONTAINE-EN-YVELINES", "cp" => "78", "adresse" => "Avenue Gabriel Péri", "nomChantier" => "Maison individuelle Mr PETIZON Laurent", "date" => "dernière semaine février 2022"],
            ["user" => "06 26 56 37 23", "societe" => "Gagny II", 'nchantier' => "21208", "statut" => "En attente OS", "ville" => "GAGNY", "cp" => "93", "adresse" => "3 Chemin des sables", "nomChantier" => "Gagny II", "date" => "courant 2023"],
            ["user" => "DAVID", "societe" => "Pôle médical et résidence séniors", 'nchantier' => "22001", "statut" => "En attente OS", "ville" => "MAISON-LAFFITTE", "cp" => "78", "adresse" => "2 avenue Fournier, rue de la Croix Saint Siméon, Place Foch", "nomChantier" => "Pôle médical et résidence séniors", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Ballanvilliers", 'nchantier' => "22002", "statut" => "A démarrer", "ville" => "BALLAINVILLIERS", "cp" => "91", "adresse" => "45 Avenue de Saint-Germain", "nomChantier" => "Ballanvilliers", "date" => "44571"],
            ["user" => "QUENTIN", "societe" => "NATIXIS", 'nchantier' => "22003", "statut" => "A démarrer", "ville" => "PARIS", "cp" => "75013", "adresse" => "79 - 85 rue du Perray", "nomChantier" => "NATIXIS", "date" => "44569"],
            ["user" => "07 88 11 83 09", "societe" => "DESIGN'TOIT Vision Plus", 'nchantier' => "22004", "statut" => "A démarrer", "ville" => "VAIRES SUR MARNE", "cp" => "77", "adresse" => "50 Avenue Pierre Mendes France", "nomChantier" => "DESIGN'TOIT Vision Plus", "date" => ""],
            ["user" => "DAVID", "societe" => "LYCEE FRANCOIS COUPERIN", 'nchantier' => "22005", "statut" => "En attente OS", "ville" => "FONTAINBLEAU", "cp" => "77300", "adresse" => "15 Avenue Jean Jaurès", "nomChantier" => "LYCEE FRANCOIS COUPERIN", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Sartrouville", 'nchantier' => "22006", "statut" => "A démarrer", "ville" => "SARTROUVILLE", "cp" => "78", "adresse" => "Route d'Hurtault", "nomChantier" => "Sartrouville", "date" => "Semaine 3"],
            ["user" => "JEREMY", "societe" => "CAP SUD", 'nchantier' => "22007", "statut" => "A démarrer", "ville" => "EVRY - COURCOURONNES", "cp" => "91", "adresse" => "8 rue Chappe", "nomChantier" => "CAP SUD", "date" => "44835"],
            ["user" => "06 48 77 68 16", "societe" => "CENTRE POMPIDOU", 'nchantier' => "22008", "statut" => "En cours", "ville" => "PARIS", "cp" => "75004", "adresse" => "Lot Z - ZAC du Centre Urbain - Rue Pierre Mauroy - Boulevard de l'Yerres", "nomChantier" => "CENTRE POMPIDOU", "date" => ""],
            ["user" => "QUENTIN", "societe" => "Le Domaine de Sully - Rénovation", 'nchantier' => "22009", "statut" => "A démarrer", "ville" => "LE MESNIL SAINT DENIS", "cp" => "78", "adresse" => "Place Georges Pompidou", "nomChantier" => "Le Domaine de Sully - Rénovation", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "LOT 9A-3", 'nchantier' => "22010", "statut" => "A démarrer", "ville" => "NEUILLY SUR MARNE", "cp" => "93", "adresse" => "Avenue de Picardie", "nomChantier" => "LOT 9A-3", "date" => "44470"],
            ["user" => "JEREMY", "societe" => "Maison n°6", 'nchantier' => "22011", "statut" => "En attente OS", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "ZAC Maison Blanche", "nomChantier" => "Maison n°6", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Hôtel - Escalier", 'nchantier' => "22012", "statut" => "A démarrer", "ville" => "MONTEVRAIN", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Hôtel - Escalier", "date" => ""],
            ["user" => "DAVID", "societe" => "Résidence étudiante : Green FabriK'/ Logement : Opaline", 'nchantier' => "22013", "statut" => "A démarrer", "ville" => "PIERREFITTE SUR SEINE", "cp" => "93", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "nomChantier" => "Résidence étudiante : Green FabriK'/ Logement : Opaline", "date" => "44835"],
            ["user" => "06 73 87 85 52", "societe" => "SNC RESIDENCE DE CHAMPS - L'Orée du Parc", 'nchantier' => "22014", "statut" => "En attente OS", "ville" => "CHAMPS SUR MARNE", "cp" => "77", "adresse" => "ZAC BRIAIS PASTEUR - 13/21 boulevard Pasteur", "nomChantier" => "SNC RESIDENCE DE CHAMPS - L'Orée du Parc", "date" => ""],
            ["user" => "", "societe" => "Groupe Scolaire", 'nchantier' => "22015", "statut" => "A démarrer", "ville" => "NOISY LE GRAND", "cp" => "93", "adresse" => "36 bis, rue de Paris", "nomChantier" => "Groupe Scolaire", "date" => ""],
            ["user" => "QUENTIN", "societe" => "Livry gargan", 'nchantier' => "22016", "statut" => "A démarrer", "ville" => "LIVRY GARGAN", "cp" => "93190", "adresse" => "6 Rue René Navier", "nomChantier" => "Livry gargan", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "Résidence les Ouches", 'nchantier' => "22017", "statut" => "A démarrer", "ville" => "EZANVILLE", "cp" => "95", "adresse" => "28 rue Vaujour", "nomChantier" => "Résidence les Ouches", "date" => "44603"],
            ["user" => "", "societe" => "Hôtel", 'nchantier' => "22018", "statut" => "A démarrer", "ville" => "MONTEVRAIN", "cp" => "77", "adresse" => "2 rue Victor Hugo", "nomChantier" => "Hôtel", "date" => ""],
            ["user" => "DAVID", "societe" => "Maison n°1", 'nchantier' => "22019", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "nomChantier" => "Maison n°1", "date" => "Voir avec JG"],
            ["user" => "06 73 87 85 52", "societe" => "Maison n°2", 'nchantier' => "22020", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°2", "date" => "Voir avec JG"],
            ["user" => "", "societe" => "Maison n°3", 'nchantier' => "22021", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°3", "date" => "Voir avec JG"],
            ["user" => "J.F ", "societe" => "Maison n°4", 'nchantier' => "22022", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°4", "date" => "Voir avec JG"],
            ["user" => "06 26 56 37 23", "societe" => "Maison n°5", 'nchantier' => "22023", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°5", "date" => "Voir avec JG"],
            ["user" => "JEREMY", "societe" => "Maison n°7", 'nchantier' => "22024", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°7", "date" => "Voir avec JG"],
            ["user" => "06 48 77 68 16", "societe" => "Maison n°8", 'nchantier' => "22025", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°8", "date" => "Voir avec JG"],
            ["user" => "JEREMY", "societe" => "Maison n°9", 'nchantier' => "22026", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°9", "date" => "Voir avec JG"],
            ["user" => "06 48 77 68 16", "societe" => "Maison n°10", 'nchantier' => "22027", "statut" => "A démarrer", "ville" => "MAREUIL LES MEAUX", "cp" => "77", "adresse" => "34 Rue Pasteur", "nomChantier" => "Maison n°10", "date" => "Voir avec JG"],
            ["user" => "J.F ", "societe" => "PRIM-ARTE", 'nchantier' => "22028", "statut" => "A démarrer", "ville" => "CHARENTON LE PONT", "cp" => "94", "adresse" => "34 Rue Pasteur", "nomChantier" => "PRIM-ARTE", "date" => ""],
            ["user" => "06 26 56 37 23", "societe" => "Maison individuelle 51 Avenue Carnot", 'nchantier' => "22029", "statut" => "A démarrer", "ville" => "SAINT MAUR DES FOSSES", "cp" => "", "adresse" => "Rue Pigeon", "nomChantier" => "Maison individuelle 51 Avenue Carnot", "date" => ""],
            ["user" => "", "societe" => "6 maisons", 'nchantier' => "22030", "statut" => "A démarrer", "ville" => "HERBLAY SUR SEINE", "cp" => "95", "adresse" => "51 Avenue Carnot", "nomChantier" => "6 maisons", "date" => "44662"],
            ["user" => "HUGO", "societe" => "SNC Academie -L'Amaryllis", 'nchantier' => "22031", "statut" => "En attente OS", "ville" => "DAMMARIE LES LYS", "cp" => "77", "adresse" => "13 rue des Tartrogons", "nomChantier" => "SNC Academie -L'Amaryllis", "date" => "44621"],
            ["user" => "06 07 42 52 33", "societe" => "SCI France", 'nchantier' => "22032", "statut" => "En attente OS", "ville" => "DAMMARIE LES LYS", "cp" => "77", "adresse" => "410 Avenue du Colonel Fabien", "nomChantier" => "SCI France", "date" => "44621"],
            ["user" => "", "societe" => "Stella Verde - Bât A", 'nchantier' => "22033", "statut" => "A démarrer", "ville" => "CHESSY", "cp" => "77", "adresse" => "783 Avenue du Colonel Fabien", "nomChantier" => "Stella Verde - Bât A", "date" => ""],
            ["user" => "", "societe" => "La Ferme de Chessy", 'nchantier' => "22034", "statut" => "A démarrer", "ville" => "CORBEIL ESSONNES", "cp" => "91", "adresse" => "Chemin du Bicheret", "nomChantier" => "La Ferme de Chessy", "date" => "Après SPCC"],
            ["user" => "QUENTIN", "societe" => "Corbeil", 'nchantier' => "22035", "statut" => "A démarrer", "ville" => "MONTEVRAIN", "cp" => "77", "adresse" => "Rue de la Papeterie - Lot A11", "nomChantier" => "Corbeil", "date" => "Commencer par le Bât C"],
            ["user" => "07 88 11 83 09", "societe" => "Hôtel", 'nchantier' => "22036", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "nomChantier" => "Hôtel", "date" => ""],
            ["user" => "QUENTIN", "societe" => "BATIMENT BACKSTAGE PORTE NAUTILUS", 'nchantier' => "22037", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "Façade n°8", "nomChantier" => "BATIMENT BACKSTAGE PORTE NAUTILUS", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "Main Street", 'nchantier' => "22038", "statut" => "A démarrer", "ville" => "CHESSY", "cp" => "77", "adresse" => "PARC DISNEYLAND", "nomChantier" => "Main Street", "date" => ""],
            ["user" => "JEREMY", "societe" => "DISNEY - PIRATE PHASE 2", 'nchantier' => "22039", "statut" => "A démarrer", "ville" => "CHILLY MAZARIN", "cp" => "91", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "DISNEY - PIRATE PHASE 2", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Le Chailly", 'nchantier' => "22040", "statut" => "A démarrer", "ville" => "BOISSY-SAINT-LEGER", "cp" => "94", "adresse" => "Boulevard du grand Fossé", "nomChantier" => "Le Chailly", "date" => ""],
            ["user" => "DAVID", "societe" => "Inspiration", 'nchantier' => "22041", "statut" => "A démarrer", "ville" => "ALFORTVILLE", "cp" => "94", "adresse" => "73/75B/77 av Charles De Gaulle & Rue Edouets", "nomChantier" => "Inspiration", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Amplitude", 'nchantier' => "22042", "statut" => "En attente OS", "ville" => "DRAVEIL", "cp" => "91", "adresse" => "ZAC de la Charmeraie_LOT 1", "nomChantier" => "Amplitude", "date" => ""],
            ["user" => "", "societe" => "Esprit Mansart", 'nchantier' => "22043", "statut" => "A démarrer", "ville" => "FONTENAY SOUS BOIS", "cp" => "94", "adresse" => "2,4,10 rue Traversière & 7 rue Victor Hugo", "nomChantier" => "Esprit Mansart", "date" => ""],
            ["user" => "", "societe" => "PATINOIRE FONTENAY SOUS BOIS", 'nchantier' => "22044", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "252/254 bis, boulevard Henri Barbusse / 1, avenue Emile Zola", "nomChantier" => "PATINOIRE FONTENAY SOUS BOIS", "date" => ""],
            ["user" => "QUENTIN", "societe" => "LA GIRAFE CURISEUSE", 'nchantier' => "22045", "statut" => "A démarrer", "ville" => "NANTEUIL LE HAUDOUIN", "cp" => "60", "adresse" => "8 avenue Charles Garcia", "nomChantier" => "LA GIRAFE CURISEUSE", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "GROUPE SCOLAIRE MAURICE CHEVANCE BERTIN", 'nchantier' => "22046", "statut" => "En attente OS", "ville" => "MONTFORT L'AMAURY", "cp" => "78", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "GROUPE SCOLAIRE MAURICE CHEVANCE BERTIN", "date" => ""],
            ["user" => "DAVID", "societe" => "Monfort l'amaury", 'nchantier' => "22047", "statut" => "A démarrer", "ville" => "JOSSIGNY", "cp" => "77", "adresse" => "7 rue Ernest Legrand", "nomChantier" => "Monfort l'amaury", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Mr BACHA", 'nchantier' => "22048", "statut" => "A démarrer", "ville" => "KREMELIN BICETRE", "cp" => "94", "adresse" => "8 avenue de la reine anne", "nomChantier" => "Mr BACHA", "date" => ""],
            ["user" => "DAVID", "societe" => "MEDIATHEQUE L'ECHO", 'nchantier' => "22049", "statut" => "A démarrer", "ville" => "Gif-sur-Yvette", "cp" => "91190", "adresse" => "A proximité du 13B rue de Tournant", "nomChantier" => "MEDIATHEQUE L'ECHO", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "LEARNING CENTER UNIVERSITE", 'nchantier' => "22050", "statut" => "A démarrer", "ville" => "FONTENAY TRESIGNY", "cp" => "77", "adresse" => "53 Avenue de Fontainbleau", "nomChantier" => "LEARNING CENTER UNIVERSITE", "date" => ""],
            ["user" => "DAVID", "societe" => "Mr et Mme Soares", 'nchantier' => "22051", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "6 Rue Noetzlin", "nomChantier" => "Mr et Mme Soares", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "TOOLBOX", 'nchantier' => "22052", "statut" => "A démarrer", "ville" => "LA QUEUE-EN-BRIE", "cp" => "94", "adresse" => "1 Square Claude Arnaud - Lot n°42", "nomChantier" => "TOOLBOX", "date" => ""],
            ["user" => "JEREMY", "societe" => "Villa des Capucines", 'nchantier' => "22053", "statut" => "A démarrer", "ville" => "SAINT MAUR DES FOSSES", "cp" => "94", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "Villa des Capucines", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "La Demeure du Vallon", 'nchantier' => "22054", "statut" => "A démarrer", "ville" => "CHARNY", "cp" => "77410", "adresse" => "39 rue du Chemin Vert", "nomChantier" => "La Demeure du Vallon", "date" => ""],
            ["user" => "JEREMY", "societe" => "DESIGN'TOIT", 'nchantier' => "22055", "statut" => "A démarrer", "ville" => "CORMEILLES-EN-PARISIS", "cp" => "95", "adresse" => "2 rue du Vallon", "nomChantier" => "DESIGN'TOIT", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "L'ultime", 'nchantier' => "22056", "statut" => "A démarrer", "ville" => "ALFORTVILLE", "cp" => "94", "adresse" => "3 Rue des écoles", "nomChantier" => "L'ultime", "date" => ""],
            ["user" => "JEREMY", "societe" => "Solaris", 'nchantier' => "22057", "statut" => "A démarrer", "ville" => "MITRY MORY", "cp" => "7290", "adresse" => "24 à 30 avenue du Gué Langlois", "nomChantier" => "Solaris", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "PAROISSE NOTRE DAME DES ANGES", 'nchantier' => "22058", "statut" => "A démarrer", "ville" => "CLAMART", "cp" => "92", "adresse" => "165-167 rue Véron - Rue Louis Blanc", "nomChantier" => "PAROISSE NOTRE DAME DES ANGES", "date" => ""],
            ["user" => "JEREMY", "societe" => "Ilot 19 - Beaurivage", 'nchantier' => "22059", "statut" => "En attente OS", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "10 BIS AVENUE BUFFON", "nomChantier" => "Ilot 19 - Beaurivage", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "DIORAMA", 'nchantier' => "22060", "statut" => "A démarrer", "ville" => "BRIE-COMTE-ROBERT", "cp" => "77", "adresse" => "ZAC du Panorama - T2 - Boulevard du Moulin de la Tour - Allée Paulette Nardal", "nomChantier" => "DIORAMA", "date" => ""],
            ["user" => "JEREMY", "societe" => "Cœur noyer", 'nchantier' => "22061", "statut" => "A démarrer", "ville" => "PARIS", "cp" => "75005", "adresse" => "PARC DISNEYLAN PARIS", "nomChantier" => "Cœur noyer", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "ENEDIS", 'nchantier' => "22062", "statut" => "A démarrer", "ville" => "NeuillySurSeine", "cp" => "92200", "adresse" => "10, rue du Grand Noyer", "nomChantier" => "ENEDIS", "date" => ""],
            ["user" => "JEREMY", "societe" => "Villa Maillot", 'nchantier' => "22063", "statut" => "A démarrer", "ville" => "PARIS 20", "cp" => "75", "adresse" => "4 rue erasme", "nomChantier" => "Villa Maillot", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "ENEDIS", 'nchantier' => "22064", "statut" => "A démarrer", "ville" => "FONTENAY-TRESIGNY", "cp" => "77", "adresse" => "4 Villa Maillot", "nomChantier" => "ENEDIS", "date" => ""],
            ["user" => "JEREMY", "societe" => "Mr ASLI", 'nchantier' => "22065", "statut" => "En attente OS", "ville" => "FONTENAY SOUS BOIS", "cp" => "94", "adresse" => "75 Rue Orfila Paris", "nomChantier" => "Mr ASLI", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Collège Juliot Curie - Bâtiment côté rue", 'nchantier' => "22066", "statut" => "En attente OS", "ville" => "FONTENAY SOUS BOIS", "cp" => "94", "adresse" => "Lotissement Le Clos Lafayette - 13, Rue du colonel Arnaud Beltrame", "nomChantier" => "Collège Juliot Curie - Bâtiment côté rue", "date" => ""],
            ["user" => "JEREMY", "societe" => "Collège Juliot Curie - Bâtiment côté cours", 'nchantier' => "22067", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77777", "adresse" => "2 rue Lesage", "nomChantier" => "Collège Juliot Curie - Bâtiment côté cours", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "TIMON", 'nchantier' => "22068", "statut" => "A démarrer", "ville" => "PARIS", "cp" => "75012", "adresse" => "2 rue Lesage", "nomChantier" => "TIMON", "date" => ""],
            ["user" => "JEREMY", "societe" => "Hopital Diaconesse", 'nchantier' => "22069", "statut" => "A démarrer", "ville" => "PANTIN", "cp" => "93", "adresse" => "Parc DisneyLand Paris", "nomChantier" => "Hopital Diaconesse", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "HERMES", 'nchantier' => "22070", "statut" => "A démarrer", "ville" => "MARCOUSSIS", "cp" => "91", "adresse" => "2 Rue du Sergent Bauchat", "nomChantier" => "HERMES", "date" => ""],
            ["user" => "JEREMY", "societe" => "DATA CENTER", 'nchantier' => "22071", "statut" => "En attente OS", "ville" => "VITRY SUR SEINE", "cp" => "94400", "adresse" => "16 RUE LESAULT", "nomChantier" => "DATA CENTER", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "UCP CHERIOUX", 'nchantier' => "22072", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "Route de Nozay", "nomChantier" => "UCP CHERIOUX", "date" => ""],
            ["user" => "QUENTIN", "societe" => "TOUR DE LA TERREUR", 'nchantier' => "22073", "statut" => "A démarrer", "ville" => "CLICHY", "cp" => "92", "adresse" => "Rue Edouard Tremblay", "nomChantier" => "TOUR DE LA TERREUR", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "CLICHY - ROGUET", 'nchantier' => "22074", "statut" => "A démarrer", "ville" => "MELUN", "cp" => "77", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "CLICHY - ROGUET", "date" => ""],
            ["user" => "ALAN", "societe" => "Nature'l", 'nchantier' => "22075", "statut" => "En attente OS", "ville" => "CHESSY", "cp" => "77", "adresse" => "86-90 RUE ROGUET", "nomChantier" => "Nature'l", "date" => ""],
            ["user" => "06 07 39 34 52", "societe" => "Chessy 4", 'nchantier' => "22076", "statut" => "A démarrer", "ville" => "VILLIERS SUR MARNE", "cp" => "94", "adresse" => "LOT 1C8 - ECOQUARTIER WOODI – PLAINE DE MONTAIGU - Rue Abbe Pierre - Avenue Paul Emile Victor - Rue Charles Peguy - Rue Genevieve de Gaulle-Anthonioz", "nomChantier" => "Chessy 4", "date" => ""],
            ["user" => "J.F ", "societe" => "Maison", 'nchantier' => "22077", "statut" => "A démarrer", "ville" => "IVRY SUR SEINE", "cp" => "94", "adresse" => "ZAC Ferme du Chateau_Chessy_Lot 18-3 / Chemin du Bicheret", "nomChantier" => "Maison", "date" => ""],
            ["user" => "06 26 56 37 23", "societe" => "Immeuble de Mr Alvarez", 'nchantier' => "22078", "statut" => "A démarrer", "ville" => "SAINT SOUPPLETS", "cp" => "77", "adresse" => "18 Av. des Saules", "nomChantier" => "Immeuble de Mr Alvarez", "date" => ""],
            ["user" => "J.F ", "societe" => "KNAUF : Sapine Roulante Chemin Câble", 'nchantier' => "22079", "statut" => "A démarrer", "ville" => "CHAMPIGNY-SUR-MARNE", "cp" => "94", "adresse" => "90 avenue Danielle Casanova", "nomChantier" => "KNAUF : Sapine Roulante Chemin Câble", "date" => ""],
            ["user" => "06 26 56 37 23", "societe" => "Maison", 'nchantier' => "22080", "statut" => "", "ville" => "Malakoff", "cp" => "92", "adresse" => "Rue de la Biziére", "nomChantier" => "Maison", "date" => ""],
            ["user" => "", "societe" => "ECOLE PAULETTE NARDAL", 'nchantier' => "22081", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "71, Rue Charles Infroit", "nomChantier" => "ECOLE PAULETTE NARDAL", "date" => ""],
            ["user" => "JEREMY", "societe" => "ENSEIGNE SORTIE SUD RATP", 'nchantier' => "22082", "statut" => "En attente OS", "ville" => "PARIS", "cp" => "75", "adresse" => "108 Rue Paul Vaillant Couturier", "nomChantier" => "ENSEIGNE SORTIE SUD RATP", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "PREFECTURE POLICE", 'nchantier' => "22083", "statut" => "A démarrer", "ville" => "ANDREZEL", "cp" => "77", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "PREFECTURE POLICE", "date" => ""],
            ["user" => "DAVID", "societe" => "Maison M. & Mme GUEDON LEGRAS", 'nchantier' => "22084", "statut" => "A démarrer", "ville" => "ANDREZEL", "cp" => "77", "adresse" => "4 Rue de la Montagne Sainte Geneviève", "nomChantier" => "Maison M. & Mme GUEDON LEGRAS", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Maison Mr et Mme Damoiselet", 'nchantier' => "22085", "statut" => "A démarrer", "ville" => "PARIS", "cp" => "75015", "adresse" => "Hameau du Pommier Doux - Lot 6 - 15 rue jean porcheray", "nomChantier" => "Maison Mr et Mme Damoiselet", "date" => ""],
            ["user" => "QUENTIN", "societe" => "37 Rue Viala", 'nchantier' => "22086", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77777", "adresse" => "Hammeau du Pommier Doux - Lot 5", "nomChantier" => "37 Rue Viala", "date" => ""],
            ["user" => "07 88 11 83 09", "societe" => "IMAGINATION T3", 'nchantier' => "22087", "statut" => "A démarrer", "ville" => "FONTENAY TRESIGNY", "cp" => "77", "adresse" => "15 rue jean porcheray", "nomChantier" => "IMAGINATION T3", "date" => ""],
            ["user" => "JEREMY", "societe" => "Maison Mr et Mme Denakpo", 'nchantier' => "22088", "statut" => "A démarrer", "ville" => "LE PERREUX SUR MARNE", "cp" => "94", "adresse" => "37 Rue Viala", "nomChantier" => "Maison Mr et Mme Denakpo", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Maison", 'nchantier' => "22089", "statut" => "A démarrer", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "Parc DinseyLand Paris", "nomChantier" => "Maison", "date" => ""],
            ["user" => "JEREMY", "societe" => "GELATI", 'nchantier' => "22090", "statut" => "A démarrer", "ville" => "CLAYES SOUS BOIS", "cp" => "78", "adresse" => "20, rue Simone VEIL", "nomChantier" => "GELATI", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Alisée", 'nchantier' => "22091", "statut" => "En attente OS", "ville" => "PARIS", "cp" => "75", "adresse" => "1Bis Rue des Arts", "nomChantier" => "Alisée", "date" => ""],
            ["user" => "JEREMY", "societe" => "Scène LACOSTE", 'nchantier' => "22092", "statut" => "A démarrer", "ville" => "TOUQUIN", "cp" => "77", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "Scène LACOSTE", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "Maison Mr VICENTE et Mme LEBUGLE -", 'nchantier' => "22093", "statut" => "A démarrer", "ville" => "PENCHARD", "cp" => "77124", "adresse" => "22 Rue Henri Prou", "nomChantier" => "Maison Mr VICENTE et Mme LEBUGLE -", "date" => ""],
            ["user" => "", "societe" => "Penchard", 'nchantier' => "22094", "statut" => "A démarrer", "ville" => "VITRY", "cp" => "94", "adresse" => "50 avenue des Champs Elysées", "nomChantier" => "Penchard", "date" => ""],
            ["user" => "", "societe" => "Bâtiment", 'nchantier' => "22095", "statut" => "En attente OS", "ville" => "Cormeilles-en-Parisis", "cp" => "95240", "adresse" => "8 Rue de Provins", "nomChantier" => "Bâtiment", "date" => ""],
            ["user" => "", "societe" => "LYCEE", 'nchantier' => "22096", "statut" => "A démarrer", "ville" => "LE BLANC MESNIL", "cp" => "93", "adresse" => "27 rue de Neufmontiers", "nomChantier" => "LYCEE", "date" => ""],
            ["user" => "", "societe" => "Chancellerie", 'nchantier' => "22097", "statut" => "A démarrer", "ville" => "NOZAY", "cp" => "91", "adresse" => "10 Av Youri Gagarine", "nomChantier" => "Chancellerie", "date" => ""],
            ["user" => "TONY", "societe" => "DATA CENTER", 'nchantier' => "22098", "statut" => "En attente OS", "ville" => "MALAKOFF", "cp" => "92", "adresse" => "Rue de Kladno", "nomChantier" => "DATA CENTER", "date" => ""],
            ["user" => "06 27 83 31 14", "societe" => "ECOLE PAULETTE NARDAL", 'nchantier' => "22099", "statut" => "A démarrer", "ville" => "CHENNEVIERES SUR MARNE", "cp" => "94", "adresse" => "2 Rue Riera et Christy", "nomChantier" => "ECOLE PAULETTE NARDAL", "date" => ""],
            ["user" => "DAVID", "societe" => "Collège Nicolas Boileau", 'nchantier' => "22100", "statut" => "A démarrer", "ville" => "Noisy le grand", "cp" => "93160", "adresse" => "97-103 avenue Pasteur", "nomChantier" => "Collège Nicolas Boileau", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Le petit Orme", 'nchantier' => "22101", "statut" => "A démarrer", "ville" => "FONTENAY TRESIGNY", "cp" => "77", "adresse" => "Rue de marcoussis", "nomChantier" => "Le petit Orme", "date" => ""],
            ["user" => "DAVID", "societe" => "Maison Mr OLIVEIRA et Mme FARIA", 'nchantier' => "22102", "statut" => "En attente OS", "ville" => "MARNE LA VALLEE", "cp" => "77", "adresse" => "108 Rue Paul Vaillant Couturier", "nomChantier" => "Maison Mr OLIVEIRA et Mme FARIA", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "STEAK HOUSE", 'nchantier' => "", "statut" => "A démarrer", "ville" => "JOINVILLE LE PONT", "cp" => "94", "adresse" => "20 Route du Plessis", "nomChantier" => "STEAK HOUSE", "date" => ""],
            ["user" => "J.F", "societe" => "Gymnase Lecuirot", 'nchantier' => "", "statut" => "A démarrer", "ville" => "JOINVILLE LE PONT", "cp" => "94", "adresse" => "31 rue des Ormes", "nomChantier" => "Gymnase Lecuirot", "date" => ""],
            ["user" => "06 26 56 37 23", "societe" => "MAIRIE DE JOINVILLE", 'nchantier' => "", "statut" => "A démarrer", "ville" => "ARCUEIL", "cp" => "94", "adresse" => "2 rue de Colonel Arnaud Beltrame", "nomChantier" => "MAIRIE DE JOINVILLE", "date" => ""],
            ["user" => "JEREMY", "societe" => "Maison Mr et Mme NGUYEN", 'nchantier' => "", "statut" => "A démarrer", "ville" => "BRY-SUR-MARNE", "cp" => "94", "adresse" => "PARC DISNEYLAND PARIS", "nomChantier" => "Maison Mr et Mme NGUYEN", "date" => ""],
            ["user" => "06 48 77 68 16", "societe" => "La poste", 'nchantier' => "", "statut" => "A démarrer", "ville" => "VALENTON", "cp" => "94", "adresse" => "28, Av. Joyeuse", "nomChantier" => "La poste", "date" => ""],
            ["user" => "DAVID", "societe" => "Parc de la Plage Bleue", 'nchantier' => "", "statut" => "A démarrer", "ville" => "VILLIERS SUR MARNE", "cp" => "94", "adresse" => "14 Av. du Président Wilson", "nomChantier" => "Parc de la Plage Bleue", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "Siège", 'nchantier' => "", "statut" => "", "ville" => "", "cp" => "", "adresse" => "23  RUE DE PARIS", "nomChantier" => "Siège", "date" => ""],
            ["user" => "HUGO", "societe" => "", 'nchantier' => "", "statut" => "", "ville" => "", "cp" => "", "adresse" => "4 rue du Midi", "nomChantier" => "", "date" => ""],
            ["user" => "06 07 42 52 33 ", "societe" => "", 'nchantier' => "", "statut" => "", "ville" => "", "cp" => "", "adresse" => "12, Boulevard du Général Gallieni", "nomChantier" => "", "date" => ""],
            ["user" => "DAVID", "societe" => "", 'nchantier' => "", "statut" => "", "ville" => "", "cp" => "", "adresse" => "29 Avenue de la Plage Bleue", "nomChantier" => "", "date" => ""],
            ["user" => "06 73 87 85 52", "societe" => "", 'nchantier' => "", "statut" => "", "ville" => "", "cp" => "", "adresse" => "351, Impasse des Armoiries", "nomChantier" => "", "date" => ""],
        ];

        foreach ($data as $key => $val) {
            $user = $userRepository->findOneByFirstname($val['user']);
            $interlocuteur = new Interlocuteur();
            $interlocuteur->setRoles(["ROLE_CLIENT"]);
            $interlocuteur->setType("societe");
            $societe = new Societe();
            $societe->setSiret($key);
            $societe->setSiren($key);
            $societe->setAdresse1($val['adresse']);
            $societe->setVille($val['ville']);
            $societe->setCodePostal($val['cp']);
            $societe->setPays('France');
            $societe->setRaisonSociale($val['societe']);
            $interlocuteur->setSociete($societe);
            $interlocuteurRepository->add($interlocuteur);
            $demande = new Demande();
            $demande->setReference($val['nchantier']);
            $demande->setClient($interlocuteur);
            $demande->setDate($val['date']);

            empty($user) ? $demande->setCreateur($this->getUser()) : $demande->setCreateur($user);
            $demande->setStatut($val['statut']);
            $demande->setAdresse1($val['adresse']);
            $demande->setVille($val['ville']);
            $demande->setCodePostal($val['cp']);

            $interlocuteurRepository->add($interlocuteur);

        }
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAll(),
            'title' => 'Liste des interlocuteurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/soustraitants', name: 'app_interlocuteur_interlocuteur_index_sous_traitant', methods: ['GET'])]
    public function sousTraitant(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_SOUS_TRAITANT'),
            'title' => 'Liste des sous traitants',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/transporteurs', name: 'app_interlocuteur_interlocuteur_index_transporteur', methods: ['GET'])]
    public function transporteur(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_TRANSPORTEUR'),
            'title' => 'Liste des transporteurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/fournisseurs', name: 'app_interlocuteur_interlocuteur_index_fournisseur', methods: ['GET'])]
    public function fournisseur(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_FOURNISSEUR'),
            'title' => 'Liste des fournisseurs',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/client', name: 'app_interlocuteur_interlocuteur_index_client', methods: ['GET'])]
    public function client(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_CLIENT'),
            'title' => 'Liste des clients',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }

    #[Route('/partenaire', name: 'app_interlocuteur_interlocuteur_index_partenaire', methods: ['GET'])]
    public function partenaire(InterlocuteurRepository $interlocuteurRepository): Response
    {
        return $this->render('interlocuteur/interlocuteur/index.html.twig', [
            'interlocuteurs' => $interlocuteurRepository->findAllByRole('ROLE_PARTENAIRE'),
            'title' => 'Liste des sous partenaire',
            'nav' => [['app_interlocuteur_interlocuteur_new', 'Créer']],
        ]);
    }


    #[Route('/new', name: 'app_interlocuteur_interlocuteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InterlocuteurRepository $interlocuteurRepository): Response
    {

        $route = $request->headers->get('referer');

        $interlocuteur = new Interlocuteur();
        if (str_contains($route, 'interlocuteur/interlocuteur/soustraitants')) {
            $interlocuteur->setRoles(['ROLE_SOUS_TRAITANT']);
        }elseif (str_contains($route,'interlocuteur/interlocuteur/client')){
            $interlocuteur->setRoles(['ROLE_CLIENT']);
        }elseif (str_contains($route,'interlocuteur/interlocuteur/transporteurs')){
            $interlocuteur->setRoles(['ROLE_TRANSPORTEUR']);
        }elseif (str_contains($route,'interlocuteur/interlocuteur/fournisseurs')){
            $interlocuteur->setRoles(['ROLE_FOURNISSEUR']);
        }

        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($interlocuteur->getType() == "personne") {
                $interlocuteur->setSociete(NULL);
            } elseif ($interlocuteur->getType() == "societe") {
                $interlocuteur->setPersonne(NULL);
            }
            try {
                $interlocuteurRepository->add($interlocuteur);
                return $this->redirectToRoute('app_interlocuteur_interlocuteur_show', ['id' => $interlocuteur->getId()], Response::HTTP_SEE_OTHER);
            } catch (OptimisticLockException $e) {
                dd($e);
            } catch (ORMException $e) {
                dd($e);
            }
        }

        return $this->renderForm('interlocuteur/interlocuteur/new.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs',
            'nav' => [],

        ]);
    }

    #[Route('/{id}', name: 'app_interlocuteur_interlocuteur_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Interlocuteur $interlocuteur, FichierRepository $fichierRepository, SluggerInterface $slugger, DemandeRepository $demandeRepository): Response
    {
        $fichier = new Fichier();

        $demamndes = $demandeRepository->findAllDemande($interlocuteur->getId());

        //  dd($demamndes);

        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('fichier')->getData();

            if ($brochureFile) {
                $fichier->setCreateur($this->getUser());
                $fichier->setInterlocuteur($interlocuteur);

                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                try {

                    $brochureFile->move(
                        __DIR__ . "/../../../uploads/" . $fichier->getTypeFichier()->getTitre() . "/",
                        $newFilename
                    );
                    $fichier->setFichier($newFilename);

                } catch (FileException $e) {
                    $this->addFlash('danger', $e->getMessage());
                    // ... handle exception if something happens during file upload
                }
            }

            $fichierRepository->add($fichier);
        }

        return $this->render('interlocuteur/interlocuteur/show.html.twig', [
            'form' => $form->createView(),
            'interlocuteur' => $interlocuteur,
            'demandes' => $demamndes,
            'title' => !empty($interlocuteur->getSociete()) ? $interlocuteur->getSociete()->getRaisonSociale() : $interlocuteur->getPersonne()->getNom(),
            'nav' => [['app_interlocuteur_interlocuteur_edit', 'Modifier', $interlocuteur->getId()]],

        ]);
    }

    #[Route('/{id}/edit', name: 'app_interlocuteur_interlocuteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $form = $this->createForm(InterlocuteurType::class, $interlocuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($interlocuteur->getType() == "personne") {
                $interlocuteur->setSociete(NULL);
            } elseif ($interlocuteur->getType() == "societe") {
                $interlocuteur->setPersonne(NULL);
            }

            $interlocuteurRepository->add($interlocuteur);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('interlocuteur/interlocuteur/edit.html.twig', [
            'interlocuteur' => $interlocuteur,
            'form' => $form,
            'title' => 'Liste des interlocuteurs',
            'nav' => [],
        ]);
    }

    #[Route('/delete/{id}', name: 'app_interlocuteur_interlocuteur_delete', methods: ['POST', 'GET'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, Interlocuteur $interlocuteur, InterlocuteurRepository $interlocuteurRepository): Response
    {

        if ($this->isCsrfTokenValid('delete' . $interlocuteur->getId(), $request->request->get('_token'))) {
            try {
                $interlocuteurRepository->remove($interlocuteur);
            } catch (OptimisticLockException|ORMException|ForeignKeyConstraintViolationException $e) {
                $this->addFlash('danger', 'Vous ne pouvez pas supprimer cette fiche car des éléments y sont liés');
                return $this->redirectToRoute('app_interlocuteur_interlocuteur_show', ['id' => $interlocuteur->getId()], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->redirectToRoute('app_interlocuteur_interlocuteur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route ('/menu/interlocuteur/{value}/{id}', name: 'app_interlocuteur_interlocuteur_menu', methods: ['GET'])]
    public function activeMenu(Interlocuteur $interlocuteur, $value, InterlocuteurRepository $interlocuteurRepository): Response
    {
        $menu = $interlocuteur->getMenu();
        $menu[$this->getUser()->getId()] = $value;
        $interlocuteur->setMenu($menu);
        try {
            $interlocuteurRepository->add($interlocuteur);
            return new Response(json_encode([
                'code' => 200,
                'message' => 'Ok'
            ]));
        } catch (OptimisticLockException|ORMException $e) {
            dd($e);
        }

        return new Response(json_encode([
            'code' => 404,
            'message' => 'Erreur'
        ]));
    }
}
