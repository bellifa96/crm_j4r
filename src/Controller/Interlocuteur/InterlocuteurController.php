<?php

namespace App\Controller\Interlocuteur;

use App\Entity\Demande;
use App\Entity\Ged\Fichier;
use App\Entity\Interlocuteur\Interlocuteur;
use App\Entity\Interlocuteur\Societe;
use App\Entity\Society\Rib;
use App\Form\Ged\FichierType;
use App\Form\Interlocuteur\InterlocuteurType;
use App\Form\Society\RibType;
use App\Repository\DemandeRepository;
use App\Repository\Ged\FichierRepository;
use App\Repository\Interlocuteur\InterlocuteurRepository;
use App\Repository\Interlocuteur\SocieteRepository;
use App\Repository\Society\RibRepository;
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
    public function index(InterlocuteurRepository $interlocuteurRepository, UserRepository $userRepository, DemandeRepository $demandeRepository, SocieteRepository $societeRepository): Response
    {

        $data = [
            ["nomChantier" => "Jardin des arts - Herblay III ", "user" => "ALAN", "client" => "PROMOGIM  ", "nChantier" => "18003", "adresse" => "Rue Alexandre Dumas-Sente des Fontaines", "cp" => "95", "ville" => "HERBLAY",],
            ["nomChantier" => "LE NAUTILUS - Récapitulatif", "user" => "QUENTIN", "client" => "DLP DISNEY  ", "nChantier" => "21143", "adresse" => "PARC DISNEYLAND", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "", "user" => "J.F", "client" => "LM DECOR  ", "nChantier" => "21144", "adresse" => "56 rue Roger Salengro", "cp" => "94", "ville" => "FONTENAY SOUS BOIS",],
            ["nomChantier" => "Cage escalier", "user" => "J.F", "client" => "Ascensus Rénovation", "nChantier" => "21145", "adresse" => "Avenue Georges V / Rue Pierre Charron", "cp" => "75", "ville" => "PARIS 8",],
            ["nomChantier" => "Créche du Soleil ", "user" => "", "client" => "BRIAND  ", "nChantier" => "21146", "adresse" => "4 rue du soleil", "cp" => "94700", "ville" => "MAISONS ALFORT",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "DESAUTEL  ", "nChantier" => "21147", "adresse" => "Rue de l'Archevêché", "cp" => "94", "ville" => "CHARENTON",],
            ["nomChantier" => "Tranche 1 : Quartier des architectes", "user" => "", "client" => "Foncier Construction  ", "nChantier" => "21149", "adresse" => "Rue Claude Nicolas Ledoux", "cp" => "92", "ville" => "LE PLESSIS ROBINSON",],
            ["nomChantier" => "M. TUTOUR", "user" => "JEREMY", "client" => "SARMATES  ", "nChantier" => "21150", "adresse" => "45 Jean Marie Kerling", "cp" => "92350", "ville" => "LE PLESSIS ROBINSON",],
            ["nomChantier" => "DE BENOIST", "user" => "", "client" => "DE BENOIST  ", "nChantier" => "21152", "adresse" => "6rue de la tournelle", "cp" => "77405", "ville" => "SAINT CYR SUR MORIN",],
            ["nomChantier" => "KNAUF_CAMERA", "user" => "JEREMY", "client" => "KNAUF  ", "nChantier" => "21153", "adresse" => "Rue de la Biziére", "cp" => "77", "ville" => "SAINT SOUPPLETS",],
            ["nomChantier" => "LES TULIPES", "user" => "", "client" => "Ramery Enveloppe  ", "nChantier" => "21154", "adresse" => "Rue de Monda", "cp" => "95", "ville" => "LUZARCHES",],
            ["nomChantier" => "", "user" => "J.F", "client" => "FACADE DU ROY  ", "nChantier" => "21155", "adresse" => "11 rue Joffre", "cp" => "94100", "ville" => "ST MAUR DES FOSSES",],
            ["nomChantier" => "DDM ", "user" => "", "client" => "DDM  ", "nChantier" => "21156", "adresse" => "2 avenue Charles De Gaulles", "cp" => "95700", "ville" => "ROISSY EN France ",],
            ["nomChantier" => "Le clos de la Roseraie", "user" => "J.F", "client" => "MORCET IMMOBILIER  ", "nChantier" => "21157", "adresse" => "2  bis  allée  Pauline Kergomard, 2 et 2 ter chemin  de  princes,  2  rue  Ernest  Tambour", "cp" => "78", "ville" => "NOISY-LE-ROI",],
            ["nomChantier" => "", "user" => "", "client" => "HORS D'EAU  ", "nChantier" => "21158", "adresse" => "2 quater rue Marceau", "cp" => "78", "ville" => "SARTROUVILLE",],
            ["nomChantier" => "Villiers 1 - 36 logts", "user" => "QUENTIN", "client" => "MDH PROMOTION  ", "nChantier" => "21159", "adresse" => "17 / 19 Rue de Chennevières", "cp" => "94", "ville" => "VILLIERS SUR MARNE",],
            ["nomChantier" => "Villa Rosa", "user" => "", "client" => "MDH PROMOTION  ", "nChantier" => "21160", "adresse" => "17 / 19 Rue de Chennevières", "cp" => "94", "ville" => "VILLIERS SUR MARNE",],
            ["nomChantier" => "Villiers 2 - 82 logts", "user" => "ALAN", "client" => "DESIGN'TOIT  ", "nChantier" => "21161", "adresse" => "14 rue de la Gare Vaires Sur Marne", "cp" => "77360", "ville" => "VAIRES SUR MARNE",],
            ["nomChantier" => "Villa Rosa", "user" => "", "client" => "SAINT AGNE IMMOBILIER  (Poky)", "nChantier" => "21162", "adresse" => "121 av du General de Gaulle", "cp" => "94", "ville" => "CHAMPIGNY SUR MARNE",],
            ["nomChantier" => "", "user" => "QUENTIN", "client" => "Altarea Cogedim  ", "nChantier" => "21163", "adresse" => "130/130B/132 - Boulevard Jean Jaures", "cp" => "92", "ville" => "CLICHY-LA-GARENNE ",],
            ["nomChantier" => "", "user" => "", "client" => "SMA (GROUPE MARQUES)  ", "nChantier" => "21164", "adresse" => "20 Route du Plessis", "cp" => "94", "ville" => "CHENNEVIERES SUR MARNE",],
            ["nomChantier" => "Résidence Priviléges", "user" => "J.F", "client" => "RCDF  ", "nChantier" => "21165", "adresse" => "5 Sente de la petite voirie/Route de Montmorency", "cp" => "95", "ville" => "SAINT PRIX",],
            ["nomChantier" => "Collège Nicolas Boileau", "user" => "", "client" => "LESZELLES  Nafylian", "nChantier" => "21166", "adresse" => "1 Avenue François Mitterand", "cp" => "77500", "ville" => "CHELLES",],
            ["nomChantier" => "Résidence intergénérationnelle.", "user" => "J.F", "client" => "Vastint France", "nChantier" => "21167", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "cp" => "77", "ville" => "MONTEVRAIN",],
            ["nomChantier" => "", "user" => "", "client" => "ARTECK  ", "nChantier" => "21168", "adresse" => "25 sente des Vignes", "cp" => "91", "ville" => "VARENNES-JARCY",],
            ["nomChantier" => "Hôtel ", "user" => "JEREMY", "client" => "PROMOGIM   ", "nChantier" => "21169", "adresse" => "rue du puisatier ", "cp" => "95", "ville" => "JOUY LE MOUTIER ",],
            ["nomChantier" => "Maison individuelle", "user" => "", "client" => "MDH promotion   ", "nChantier" => "21170", "adresse" => "Rue Louis Bréguet - Rue Barbuse - Bd du Maréchal Bessières", "cp" => "77", "ville" => "MEAUX",],
            ["nomChantier" => "ZAC de l'hautiloise ", "user" => "DAVID", "client" => "BRIAND  ", "nChantier" => "21171", "adresse" => "4 Rue Pelletan", "cp" => "94140", "ville" => "ALFORTVILLE",],
            ["nomChantier" => "Le Clos Bregeut", "user" => "", "client" => "Altarea Cogedim  ", "nChantier" => "21172", "adresse" => " 273/279 Avenue de Fontainebleau - Allée Jules Verne - Avenue du Luxembourg ", "cp" => "94", "ville" => "THIAIS",],
            ["nomChantier" => "Collège HENRI BARBUSSE - Mur extérieur", "user" => "", "client" => "Altarea Cogedim  ", "nChantier" => "21173", "adresse" => "150 à 154 Boulevard de Strasbourg / Rue du Fort / Route de Stalingrad", "cp" => "94", "ville" => "NOGENT SUR MARNE",],
            ["nomChantier" => "Beaux accords - Tranche 1 – 162 LOTS ", "user" => "DAVID", "client" => "Altarea Cogedim  ", "nChantier" => "21174", "adresse" => "159-167, avenue Aristide Briand/Allée Olivier/Allée de Pretoria", "cp" => "93", "ville" => "LES PAVILLONS SOUS BOIS",],
            ["nomChantier" => "Tranche 1", "user" => "", "client" => "Altarea Cogedim  ", "nChantier" => "21175", "adresse" => "Rue Léon Blum / Rue Gabriel Péri", "cp" => "92", "ville" => "CLICHY LA GARENNES",],
            ["nomChantier" => "La Promenade d'Aristide ", "user" => "JEREMY", "client" => "SPCC", "nChantier" => "21176", "adresse" => "7 rue de Cossigny", "cp" => "77170", "ville" => "BRIE COMTE ROBERT",],
            ["nomChantier" => "SNC COGEDIM PARIS METROPOLE", "user" => "", "client" => "BRIAND  ", "nChantier" => "21177", "adresse" => "5 Rue de l'Abreuvoir", "cp" => "94", "ville" => "CHAMPIGNY SUR MARNE",],
            ["nomChantier" => "Square Rose Guerin - RATP", "user" => "", "client" => "Mairie de Paris  ", "nChantier" => "21178", "adresse" => "19 rue des Abbesses", "cp" => "75", "ville" => "PARIS 18",],
            ["nomChantier" => "Révélation", "user" => "QUENTIN", "client" => "ISOBAT 93  ", "nChantier" => "21179", "adresse" => "21 rue des vieilles vignes ", "cp" => "77", "ville" => "Croissy Beaubourg",],
            ["nomChantier" => "Centre Municipal de Santé Pierre Rouques", "user" => "", "client" => "SARMATES  ", "nChantier" => "21180", "adresse" => "118 avenue de Fontainebleau", "cp" => "94270", "ville" => "Le Kremlin-Bicetre",],
            ["nomChantier" => "Eglise Saint Jean de Montmartre", "user" => "ALAN", "client" => "DSD ", "nChantier" => "21181", "adresse" => "Ilot 6 - Avenue Jules Guesde", "cp" => "92", "ville" => "SCEAUX",],
            ["nomChantier" => "Centre de conférence ", "user" => "", "client" => "DSA", "nChantier" => "21182", "adresse" => "ZAC des Trois Ormes - Lots N04 C5, N04 C6, N04 C7, N04 C8 et N04 C9", "cp" => "77", "ville" => "COUPVRAY",],
            ["nomChantier" => "", "user" => "J.F", "client" => "LEGENDRE IMMOBILIER  ", "nChantier" => "21184", "adresse" => "59b rue de la Chapelle ", "cp" => "75", "ville" => "PARIS 18",],
            ["nomChantier" => "Sceaux quatre chemin", "user" => "", "client" => "DESAUTEL  ", "nChantier" => "21185", "adresse" => "2 cité du Cardinal Lemoine", "cp" => "75005", "ville" => "PARIS",],
            ["nomChantier" => "Bâtiment F2 ", "user" => "DAVID", "client" => "HORS D'EAU", "nChantier" => "21186", "adresse" => "11 avenue Jules Verne - Lot B", "cp" => "78", "ville" => "MONTESSON",],
            ["nomChantier" => "", "user" => "", "client" => "GIBIER", "nChantier" => "21187", "adresse" => "2, 4 avenue Paul Deroulede", "cp" => "94", "ville" => "VINCENNES",],
            ["nomChantier" => "ENEDIS", "user" => "DAVID", "client" => "SARMATES  ", "nChantier" => "21188", "adresse" => "36 Rue de chennevieres", "cp" => "94420", "ville" => "LE PLESSIS TREVISE",],
            ["nomChantier" => "Mr TORCHUT", "user" => "", "client" => "ECM  ", "nChantier" => "21189", "adresse" => "7b à 11, rue Adolphe Briffault - 97 à 99 rue Gilbert Rousset", "cp" => "92", "ville" => "ASNIERES-SUR-SEINE",],
            ["nomChantier" => "", "user" => "J.F", "client" => "STRP", "nChantier" => "21190", "adresse" => "Rue de Lisbonne", "cp" => "93", "ville" => "ROSNY SOUS BOIS",],
            ["nomChantier" => "", "user" => "", "client" => "FAM  PARC DISNEYLAND PARIS", "nChantier" => "21191", "adresse" => "ZAC Coteaux Beauclair / Lot C2", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "F.F.C.K  ", "nChantier" => "21192", "adresse" => "PAC DISNEYLAND PARIS", "cp" => "77", "ville" => "VAIRES SUR MARNE",],
            ["nomChantier" => "High Garden", "user" => "", "client" => "SMA  ", "nChantier" => "21193", "adresse" => "Base Nautique Olympique, Route de Torcy, 77360 ", "cp" => "94", "ville" => "ALFORTVILLE",],
            ["nomChantier" => "CAFE DES CASCADEURS", "user" => "JEREMY", "client" => "EDOUARD DENIS PROMOTION  ", "nChantier" => "21194", "adresse" => "Place du 11 Novembre", "cp" => "77", "ville" => "CHAMPS-SUR-MARNE",],
            ["nomChantier" => "Fédération Française de Canoë Kayak et Sports de Pagaie", "user" => "", "client" => "MAIGNE ETANCHEITE  ", "nChantier" => "21195", "adresse" => "105-109, boulevard de la République", "cp" => "75", "ville" => "PARIS 4",],
            ["nomChantier" => "CRECHE DEPARTEMENTALE DU GRAND ENSEMBLE", "user" => "", "client" => "HORS D'EAU  ", "nChantier" => "21196", "adresse" => "41 rue du Temple", "cp" => "78", "ville" => "HOUILLES",],
            ["nomChantier" => "L'allée des Champs", "user" => "", "client" => "Vastint France", "nChantier" => "21197", "adresse" => "13 rue de Verdun - Lot B", "cp" => "77", "ville" => "MONTEVRAIN",],
            ["nomChantier" => "", "user" => "", "client" => "BELLAPART  ", "nChantier" => "21198", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "cp" => "75", "ville" => "PARIS 8",],
            ["nomChantier" => "SCI CDS Company ", "user" => "", "client" => "STRP ", "nChantier" => "21199", "adresse" => "14 Rue Royale", "cp" => "93", "ville" => "BONDY",],
            ["nomChantier" => "Hôtel ", "user" => "JEREMY", "client" => "Arche Promotion  ", "nChantier" => "21200", "adresse" => "60  Avenue du Maréchal de Lattre de Tassigny", "cp" => "77", "ville" => "LIVRY SUR SEINE",],
            ["nomChantier" => "", "user" => "", "client" => "MARIGNAN RESIDENCES  ", "nChantier" => "21201", "adresse" => "27 Rue du Four à Chaux", "cp" => "75", "ville" => "PARIS 13",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "Les Sitelles  ", "nChantier" => "21202", "adresse" => "Rue Jean Antoine de Baif / Allée Paris-Ivry / Boulevard du Général d'Armée Jean Simon", "cp" => "77", "ville" => "MELUN",],
            ["nomChantier" => "", "user" => "", "client" => "Sarmates  ", "nChantier" => "21203", "adresse" => "4 rue Dajot", "cp" => "94", "ville" => "LE KREMLIN BICETRE",],
            ["nomChantier" => "Alguésens/Semapa ", "user" => "JEREMY", "client" => "BOUYGUES IMMOBILIER  ", "nChantier" => "21204", "adresse" => "10 Rue Etienne Dolet", "cp" => "77", "ville" => "CHESSY",],
            ["nomChantier" => "Les Ateliers Dajot ", "user" => "", "client" => "ACPMC  ", "nChantier" => "21205", "adresse" => "Lot AF4A19 / Quartier des Studios et Congrès", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "SERVICES MUNICIPAUX", "user" => "JEREMY", "client" => "PROMOGIM  ", "nChantier" => "21206", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "91", "ville" => "JUVISY SUR ORGE",],
            ["nomChantier" => "Rhapsody in blue ", "user" => "", "client" => "ARTECK  ", "nChantier" => "21207", "adresse" => "Avenue Gabriel Péri", "cp" => "78", "ville" => "CLAIREFONTAINE-EN-YVELINES",],
            ["nomChantier" => "Pirates des Caraibes (Disney)", "user" => "DAVID", "client" => "Altarea Cogedim  ", "nChantier" => "21208", "adresse" => "3 Chemin des sables", "cp" => "93", "ville" => "GAGNY",],
            ["nomChantier" => "Juvisy Sur Orge III 91", "user" => "", "client" => "SPCC", "nChantier" => "22001", "adresse" => "2 avenue Fournier, rue de la Croix Saint Siméon, Place Foch", "cp" => "78", "ville" => "MAISON-LAFFITTE",],
            ["nomChantier" => "Maison individuelle Mr PETIZON Laurent ", "user" => "", "client" => "HORS D'EAU  ", "nChantier" => "22002", "adresse" => "45 Avenue de Saint-Germain", "cp" => "91", "ville" => "BALLAINVILLIERS",],
            ["nomChantier" => "Gagny II", "user" => "", "client" => "DESAUTEL  ", "nChantier" => "22003", "adresse" => "79 - 85 rue du Perray", "cp" => "75013", "ville" => "PARIS",],
            ["nomChantier" => "Pôle médical et résidence pour séniors", "user" => "", "client" => "DESIGN'TOIT  ", "nChantier" => "22004", "adresse" => "50 Avenue Pierre Mendes France", "cp" => "77", "ville" => "VAIRES SUR MARNE ",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "SOFRAT  ", "nChantier" => "22005", "adresse" => "15 Avenue Jean Jaurès", "cp" => "77300", "ville" => "FONTAINBLEAU",],
            ["nomChantier" => "NATIXIS", "user" => "", "client" => "HORS D'EAU  ", "nChantier" => "22006", "adresse" => "Route d'Hurtault", "cp" => "78", "ville" => "SARTROUVILLE",],
            ["nomChantier" => "DESIGN'TOIT Vision Plus", "user" => "J.F", "client" => "BOUYGUES IMMOBILIER  ", "nChantier" => "22007", "adresse" => "8 rue Chappe", "cp" => "91", "ville" => "EVRY - COURCOURONNES",],
            ["nomChantier" => "LYCEE FRANCOIS COUPERIN", "user" => "", "client" => "GROUPE ANDY  ", "nChantier" => "22008", "adresse" => "Lot Z - ZAC du Centre Urbain - Rue Pierre Mauroy - Boulevard de l'Yerres", "cp" => "75004", "ville" => "PARIS",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "ECM  ", "nChantier" => "22009", "adresse" => "Place Georges Pompidou", "cp" => "78", "ville" => "LE MESNIL SAINT DENIS",],
            ["nomChantier" => "CAP SUD", "user" => "", "client" => "HORS D'EAU  ", "nChantier" => "22010", "adresse" => "Avenue de Picardie", "cp" => "93", "ville" => "NEUILLY SUR MARNE",],
            ["nomChantier" => "CENTRE POMPIDOU", "user" => "DAVID", "client" => "HEXAOM  ", "nChantier" => "22011", "adresse" => "ZAC Maison Blanche", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Le Domaine de Sully - Rénovation", "user" => "", "client" => "Vastint France", "nChantier" => "22012", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MONTEVRAIN",],
            ["nomChantier" => "LOT 9A-3", "user" => "DAVID", "client" => "LEROUX  BOUYGUES IMMOBILIER", "nChantier" => "22013", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "cp" => "93", "ville" => "PIERREFITTE SUR SEINE",],
            ["nomChantier" => "Maison n°6", "user" => "", "client" => "LES SITELLES  ", "nChantier" => "22014", "adresse" => "ZAC BRIAIS PASTEUR - 13/21 boulevard Pasteur", "cp" => "77", "ville" => "CHAMPS SUR MARNE",],
            ["nomChantier" => "Hôtel - Escalier", "user" => "DAVID", "client" => "MAISON NEUVE  ", "nChantier" => "22015", "adresse" => "36 bis, rue de Paris", "cp" => "93", "ville" => "NOISY LE GRAND",],
            ["nomChantier" => "Résidence étudiante : Green FabriK'/ Logement : Opaline ", "user" => "", "client" => "DESIGN'TOIT  ", "nChantier" => "22016", "adresse" => "6 Rue René Navier", "cp" => "93190", "ville" => "LIVRY GARGAN ",],
            ["nomChantier" => "SNC RESIDENCE DE CHAMPS - L'Orée du Parc ", "user" => "JEREMY", "client" => "AETIUS TOITURES  ", "nChantier" => "22017", "adresse" => "28 rue Vaujour", "cp" => "95", "ville" => "EZANVILLE",],
            ["nomChantier" => "Groupe Scolaire", "user" => "", "client" => "TELAMON", "nChantier" => "22018", "adresse" => "2 rue Victor Hugo", "cp" => "77", "ville" => "MONTEVRAIN",],
            ["nomChantier" => "", "user" => "QUENTIN", "client" => "HEXAOM", "nChantier" => "22019", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Résidence les Ouches", "user" => "", "client" => "HEXAOM", "nChantier" => "22020", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Hôtel ", "user" => "QUENTIN", "client" => "HEXAOM  ", "nChantier" => "22021", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°1", "user" => "", "client" => "HEXAOM  ", "nChantier" => "22022", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°2", "user" => "QUENTIN", "client" => "HEXAOM", "nChantier" => "22023", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°3", "user" => "", "client" => "HEXAOM", "nChantier" => "22024", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°4", "user" => "DAVID", "client" => "HEXAOM", "nChantier" => "22025", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°5", "user" => "", "client" => "HEXAOM", "nChantier" => "22026", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°7", "user" => "J.F", "client" => "HEXAOM", "nChantier" => "22027", "adresse" => "34 Rue Pasteur", "cp" => "77", "ville" => "MAREUIL LES MEAUX",],
            ["nomChantier" => "Maison n°8", "user" => "", "client" => "PRIM-ARTE  ", "nChantier" => "22028", "adresse" => "34 Rue Pasteur", "cp" => "94", "ville" => "CHARENTON LE PONT",],
            ["nomChantier" => "Maison n°9", "user" => "DAVID", "client" => "DATIN BAT  ", "nChantier" => "22029", "adresse" => "Rue Pigeon", "cp" => "", "ville" => "SAINT MAUR DES FOSSES",],
            ["nomChantier" => "Maison n°10", "user" => "", "client" => "Maisons France STYLE  (ISIS)", "nChantier" => "22030", "adresse" => "51 Avenue Carnot", "cp" => "95", "ville" => "HERBLAY SUR SEINE",],
            ["nomChantier" => "PRIM-ARTE", "user" => "QUENTIN", "client" => "STRADIM  ", "nChantier" => "22031", "adresse" => "13 rue des Tartrogons", "cp" => "77", "ville" => "DAMMARIE LES LYS",],
            ["nomChantier" => "Maison individuelle 51 Avenue Carnot", "user" => "", "client" => "STRADIM  ", "nChantier" => "22032", "adresse" => "410 Avenue du Colonel Fabien", "cp" => "77", "ville" => "DAMMARIE LES LYS",],
            ["nomChantier" => "6 maisons", "user" => "DAVID", "client" => "Altarea Cogedim  ", "nChantier" => "22033", "adresse" => "783 Avenue du Colonel Fabien", "cp" => "77", "ville" => "CHESSY",],
            ["nomChantier" => "SNC Academie -L'Amaryllis", "user" => "", "client" => "ART façades", "nChantier" => "22034", "adresse" => "Chemin du Bicheret ", "cp" => "91", "ville" => "CORBEIL ESSONNES",],
            ["nomChantier" => "SCI France", "user" => "JEREMY", "client" => "TELAMON", "nChantier" => "22035", "adresse" => "Rue de la Papeterie - Lot A11", "cp" => "77", "ville" => "MONTEVRAIN",],
            ["nomChantier" => "Stella Verde - Bât A ", "user" => "", "client" => "DUVERGT/SOCATEB", "nChantier" => "22036", "adresse" => "2 Avenue de l'Europe / Rue de Luxembourg", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "La Ferme de Chessy", "user" => "", "client" => "SOCATEB  ", "nChantier" => "22037", "adresse" => "Façade n°8", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "ETANCHECO", "nChantier" => "22038", "adresse" => "PARC DISNEYLAND", "cp" => "77", "ville" => "CHESSY",],
            ["nomChantier" => "Hôtel ", "user" => "", "client" => "GIBIER", "nChantier" => "22039", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "91", "ville" => "CHILLY MAZARIN",],
            ["nomChantier" => "BATIMENT BACKSTAGE PORTE NAUTILUS", "user" => "DAVID", "client" => "RCDF", "nChantier" => "22040", "adresse" => "Boulevard du grand Fossé ", "cp" => "94", "ville" => "BOISSY-SAINT-LEGER",],
            ["nomChantier" => "Main Street", "user" => "", "client" => "RCDF ", "nChantier" => "22041", "adresse" => "73/75B/77 av Charles De Gaulle & Rue Edouets", "cp" => "94", "ville" => "ALFORTVILLE",],
            ["nomChantier" => "DISNEY - PIRATE PHASE 2", "user" => "", "client" => "Altarea Cogedim  ", "nChantier" => "22042", "adresse" => "ZAC de la Charmeraie_LOT 1", "cp" => "91", "ville" => "DRAVEIL",],
            ["nomChantier" => "Le Chailly", "user" => "QUENTIN", "client" => "MAISON NEUVE  ", "nChantier" => "22043", "adresse" => "2,4,10 rue Traversière & 7 rue Victor Hugo", "cp" => "94", "ville" => "FONTENAY SOUS BOIS",],
            ["nomChantier" => "Inspiration", "user" => "", "client" => "FAM", "nChantier" => "22044", "adresse" => "252/254 bis, boulevard Henri Barbusse / 1, avenue Emile Zola", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "Amplitude", "user" => "", "client" => "Ramery Enveloppe  ", "nChantier" => "22045", "adresse" => "8 avenue Charles Garcia", "cp" => "60", "ville" => "NANTEUIL LE HAUDOUIN",],
            ["nomChantier" => "Esprit Mansart ", "user" => "DAVID", "client" => "SOFRAT  ", "nChantier" => "22046", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "78", "ville" => "MONTFORT L'AMAURY",],
            ["nomChantier" => "PATINOIRE FONTENAY SOUS BOIS", "user" => "", "client" => "SOGESMI-LDT (Groupe Lesterlin)  (Isis)", "nChantier" => "22047", "adresse" => "7 rue Ernest Legrand", "cp" => "77", "ville" => "JOSSIGNY",],
            ["nomChantier" => "LA GIRAFE CURISEUSE", "user" => "", "client" => "SARMATES  ", "nChantier" => "22048", "adresse" => "8 avenue de la reine anne", "cp" => "94", "ville" => "KREMELIN BICETRE",],
            ["nomChantier" => "GROUPE SCOLAIRE MAURICE CHEVANCE BERTIN", "user" => "J.F", "client" => "ROUX FRERES  ", "nChantier" => "22049", "adresse" => "A proximité du 13B rue de Tournant", "cp" => "91190", "ville" => "Gif-sur-Yvette",],
            ["nomChantier" => "", "user" => "", "client" => "Cofidim  (Isis)", "nChantier" => "22050", "adresse" => "53 Avenue de Fontainbleau", "cp" => "77", "ville" => "FONTENAY TRESIGNY",],
            ["nomChantier" => "Mr BACHA", "user" => "JEREMY", "client" => "ACPMC  ", "nChantier" => "22051", "adresse" => "6 Rue Noetzlin", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "MEDIATHEQUE L'ECHO", "user" => "", "client" => "AGZ CONSTRUCTION", "nChantier" => "22052", "adresse" => "1 Square Claude Arnaud - Lot n°42", "cp" => "94", "ville" => "LA QUEUE-EN-BRIE",],
            ["nomChantier" => "LEARNING CENTER UNIVERSITE", "user" => "JEREMY", "client" => "AFC promotion  ", "nChantier" => "22053", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "94", "ville" => "SAINT MAUR DES FOSSES",],
            ["nomChantier" => "Mr et Mme Soares ", "user" => "", "client" => "DESIGN'TOIT  ", "nChantier" => "22054", "adresse" => "39 rue du Chemin Vert", "cp" => "77410", "ville" => "CHARNY",],
            ["nomChantier" => "TOOLBOX", "user" => "J.F", "client" => "RCDF  ", "nChantier" => "22055", "adresse" => "2 rue du Vallon", "cp" => "95", "ville" => "CORMEILLES-EN-PARISIS",],
            ["nomChantier" => "Villa des Capucines ", "user" => "", "client" => "RCDF", "nChantier" => "22056", "adresse" => "3 Rue des écoles ", "cp" => "94", "ville" => "ALFORTVILLE",],
            ["nomChantier" => "La Demeure du Vallon", "user" => "", "client" => "PAROISSE NOTRE DAME DES ANGES  ", "nChantier" => "22057", "adresse" => "24 à 30 avenue du Gué Langlois", "cp" => "7290", "ville" => "MITRY MORY",],
            ["nomChantier" => "DESIGN'TOIT", "user" => "HUGO", "client" => "VERRECCHIA  ", "nChantier" => "22058", "adresse" => "165-167 rue Véron - Rue Louis Blanc", "cp" => "92", "ville" => "CLAMART",],
            ["nomChantier" => "L'ultime", "user" => "", "client" => "AC ETANCHEITE  ", "nChantier" => "22059", "adresse" => "10 BIS AVENUE BUFFON", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "Solaris", "user" => "", "client" => "SPCC  KAUFMAN & BROAD", "nChantier" => "22060", "adresse" => "ZAC du Panorama - T2 - Boulevard du Moulin de la Tour - Allée Paulette Nardal", "cp" => "77", "ville" => "BRIE-COMTE-ROBERT",],
            ["nomChantier" => "PAROISSE NOTRE DAME DES ANGES ", "user" => "", "client" => "DESAUTEL  ", "nChantier" => "22061", "adresse" => "PARC DISNEYLAN PARIS", "cp" => "75005", "ville" => "PARIS",],
            ["nomChantier" => "Ilot 19 - Beaurivage", "user" => "QUENTIN", "client" => "PIERRE NOEL  ", "nChantier" => "22062", "adresse" => "10, rue du Grand Noyer", "cp" => "92200", "ville" => "NeuillySurSeine",],
            ["nomChantier" => "DIORAMA", "user" => "", "client" => "DESAUTEL  ", "nChantier" => "22063", "adresse" => "4 rue erasme", "cp" => "75", "ville" => "PARIS 20",],
            ["nomChantier" => "Cœur noyer ", "user" => "QUENTIN", "client" => "HEXAOM", "nChantier" => "22064", "adresse" => "4 Villa Maillot", "cp" => "77", "ville" => "FONTENAY-TRESIGNY",],
            ["nomChantier" => "ENEDIS", "user" => "", "client" => "BRIAND MENUISERIE  ", "nChantier" => "22065", "adresse" => "75 Rue Orfila Paris ", "cp" => "94", "ville" => "FONTENAY SOUS BOIS",],
            ["nomChantier" => "Villa Maillot", "user" => "JEREMY", "client" => "BRIAND MENUISERIE  ", "nChantier" => "22066", "adresse" => "Lotissement 'Le Clos Lafayette' - 13, Rue du colonel Arnaud Beltrame", "cp" => "94", "ville" => "FONTENAY SOUS BOIS",],
            ["nomChantier" => "ENEDIS", "user" => "", "client" => "VigaAsphalt", "nChantier" => "22067", "adresse" => "2 rue Lesage", "cp" => "77777", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "Mr ASLI ", "user" => "DAVID", "client" => "SARMATES  ", "nChantier" => "22068", "adresse" => "2 rue Lesage", "cp" => "75012", "ville" => "PARIS",],
            ["nomChantier" => "Collège Juliot Curie - Bâtiment côté rue", "user" => "", "client" => "SARMATES  ", "nChantier" => "22069", "adresse" => "Parc DisneyLand Paris", "cp" => "93", "ville" => "PANTIN",],
            ["nomChantier" => "Collège Juliot Curie - Bâtiment côté cours", "user" => "", "client" => "Generale Prefabbricati  ", "nChantier" => "22070", "adresse" => "2 Rue du Sergent Bauchat", "cp" => "91", "ville" => "MARCOUSSIS",],
            ["nomChantier" => "TIMON", "user" => "", "client" => "MAISON NEUVE  ", "nChantier" => "22071", "adresse" => "16 RUE LESAULT", "cp" => "94400", "ville" => "VITRY SUR SEINE",],
            ["nomChantier" => "Hopital Diaconesse", "user" => "QUENTIN", "client" => "DLP DISNEY  ", "nChantier" => "22072", "adresse" => "Route de Nozay", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "HERMES", "user" => "", "client" => "DELACOMMUNE", "nChantier" => "22073", "adresse" => "Rue Edouard Tremblay", "cp" => "92", "ville" => "CLICHY",],
            ["nomChantier" => "DATA CENTER", "user" => "DAVID", "client" => "BOUYGUES IMMOBILIER  ", "nChantier" => "22074", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "77", "ville" => "MELUN",],
            ["nomChantier" => "UCP CHERIOUX", "user" => "", "client" => "PROMOGIM  ", "nChantier" => "22075", "adresse" => "86-90 RUE ROGUET", "cp" => "77", "ville" => "CHESSY",],
            ["nomChantier" => "TOUR DE LA TERREUR", "user" => "DAVID", "client" => "CRFF  M. Mathieu", "nChantier" => "22076", "adresse" => "LOT 1C8 - ECOQUARTIER WOODI – PLAINE DE MONTAIGU - Rue Abbe Pierre - Avenue Paul Emile Victor - Rue Charles Peguy - Rue Genevieve de Gaulle-Anthonioz ", "cp" => "94", "ville" => "VILLIERS SUR MARNE",],
            ["nomChantier" => "CLICHY - ROGUET", "user" => "", "client" => "Bairrada Couverture  ", "nChantier" => "22077", "adresse" => "ZAC Ferme du Chateau_Chessy_Lot 18-3 / Chemin du Bicheret", "cp" => "94", "ville" => "IVRY SUR SEINE",],
            ["nomChantier" => "Nature'l ", "user" => "DAVID", "client" => "KNAUF  ", "nChantier" => "22078", "adresse" => "18 Av. des Saules", "cp" => "77", "ville" => "SAINT SOUPPLETS",],
            ["nomChantier" => "Chessy 4", "user" => "", "client" => "OPTIC-BTP  M. Claire", "nChantier" => "22079", "adresse" => "90 avenue Danielle Casanova", "cp" => "94", "ville" => "CHAMPIGNY-SUR-MARNE",],
            ["nomChantier" => "Maison", "user" => "JEREMY", "client" => "BRIAND  ", "nChantier" => "22080", "adresse" => "Rue de la Biziére", "cp" => "92", "ville" => "Malakoff",],
            ["nomChantier" => "Immeuble de Mr Alvarez", "user" => "", "client" => "REAL ESTATE  DISNEYLAND PARIS", "nChantier" => "22081", "adresse" => "71, Rue Charles Infroit", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "KNAUF : Sapine Roulante Chemin Câble", "user" => "JEREMY", "client" => "RENOV 94  ", "nChantier" => "22082", "adresse" => "108 Rue Paul Vaillant Couturier", "cp" => "75", "ville" => "PARIS",],
            ["nomChantier" => "Maison", "user" => "", "client" => "COFIDIM", "nChantier" => "22083", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "77", "ville" => "ANDREZEL",],
            ["nomChantier" => "ECOLE PAULETTE NARDAL", "user" => "JEREMY", "client" => "COFIDIM", "nChantier" => "22084", "adresse" => "4 Rue de la Montagne Sainte Geneviève", "cp" => "77", "ville" => "ANDREZEL",],
            ["nomChantier" => "ENSEIGNE SORTIE SUD RATP", "user" => "", "client" => "AC COUVERTURE  ", "nChantier" => "22085", "adresse" => " 'Hameau du Pommier Doux' - Lot 6 - 15 rue jean porcheray", "cp" => "75015", "ville" => "PARIS",],
            ["nomChantier" => "PREFECTURE POLICE", "user" => "JEREMY", "client" => "VigaAsphalt", "nChantier" => "22086", "adresse" => "Hammeau du Pommier Doux - Lot 5", "cp" => "77777", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "Maison M. & Mme GUEDON LEGRAS", "user" => "", "client" => "Maisons Lelievre  (Isis)", "nChantier" => "22087", "adresse" => "15 rue jean porcheray", "cp" => "77", "ville" => "FONTENAY TRESIGNY",],
            ["nomChantier" => "Maison Mr et Mme Damoiselet", "user" => "JEREMY", "client" => "Mr. LAGIER Olivier  ", "nChantier" => "22088", "adresse" => "37 Rue Viala", "cp" => "94", "ville" => "LE PERREUX SUR MARNE",],
            ["nomChantier" => "", "user" => "", "client" => "DLP DISNEY", "nChantier" => "22089", "adresse" => "Parc DinseyLand Paris", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "IMAGINATION T3", "user" => "JEREMY", "client" => "GIBIER", "nChantier" => "22090", "adresse" => "20, rue Simone VEIL", "cp" => "78", "ville" => "CLAYES SOUS BOIS",],
            ["nomChantier" => "Maison Mr et Mme Denakpo", "user" => "", "client" => "COFIDIM", "nChantier" => "22092", "adresse" => "1Bis Rue des Arts", "cp" => "77", "ville" => "TOUQUIN",],
            ["nomChantier" => "Maison", "user" => "JEREMY", "client" => "DESIGNTOITS  ", "nChantier" => "22093", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "77124", "ville" => "PENCHARD",],
            ["nomChantier" => "GELATI", "user" => "", "client" => "Inter Isolation  ", "nChantier" => "22094", "adresse" => "22 Rue Henri Prou", "cp" => "94", "ville" => "VITRY",],
            ["nomChantier" => "Alisée", "user" => "JEREMY", "client" => "ROUX FRERES  ", "nChantier" => "22095", "adresse" => "8 Rue de Provins", "cp" => "95240", "ville" => "Cormeilles-en-Parisis",],
            ["nomChantier" => "Maison Mr VICENTE et Mme LEBUGLE -", "user" => "", "client" => "GIBIER", "nChantier" => "22096", "adresse" => "27 rue de Neufmontiers", "cp" => "93", "ville" => "LE BLANC MESNIL",],
            ["nomChantier" => "", "user" => "JEREMY", "client" => "IMOGIS  ", "nChantier" => "22097", "adresse" => "10 Av Youri Gagarine", "cp" => "91", "ville" => "NOZAY",],
            ["nomChantier" => "Bâtiment", "user" => "", "client" => "BRIAND  ", "nChantier" => "22098", "adresse" => "Rue de Kladno", "cp" => "92", "ville" => "MALAKOFF",],
            ["nomChantier" => "LYCEE ", "user" => "JEREMY", "client" => "SMA (GROUPE MARQUES)  ", "nChantier" => "22099", "adresse" => "2 Rue Riera et Christy", "cp" => "94", "ville" => "CHENNEVIERES SUR MARNE",],
            ["nomChantier" => "Chancellerie ", "user" => "", "client" => "Montoit  ", "nChantier" => "22100", "adresse" => "97-103 avenue Pasteur", "cp" => "93160", "ville" => "Noisy le grand",],
            ["nomChantier" => "DATA CENTER", "user" => "QUENTIN", "client" => "COFIDIM", "nChantier" => "22101", "adresse" => "Rue de marcoussis", "cp" => "77", "ville" => "FONTENAY TRESIGNY",],
            ["nomChantier" => "ECOLE PAULETTE NARDAL", "user" => "", "client" => "AC ETANCHEITE  ", "nChantier" => "22102", "adresse" => "108 Rue Paul Vaillant Couturier", "cp" => "77", "ville" => "MARNE LA VALLEE",],
            ["nomChantier" => "Collège Nicolas Boileau", "user" => "ALAN", "client" => "BRIAND  ", "nChantier" => "22103", "adresse" => "20 Route du Plessis", "cp" => "94", "ville" => "JOINVILLE LE PONT",],
            ["nomChantier" => "Le petit Orme", "user" => "", "client" => "BRIAND  ", "nChantier" => "22104", "adresse" => "31 rue des Ormes", "cp" => "94", "ville" => "JOINVILLE LE PONT",],
            ["nomChantier" => "Maison Mr OLIVEIRA et Mme FARIA", "user" => "J.F", "client" => "HORS D'EAU  ", "nChantier" => "22105", "adresse" => "2 rue de Colonel Arnaud Beltrame", "cp" => "94", "ville" => "ARCUEIL",],
            ["nomChantier" => "STEAK HOUSE", "user" => "", "client" => "DDM  La Poste", "nChantier" => "22106", "adresse" => "PARC DISNEYLAND PARIS", "cp" => "94", "ville" => "BRY-SUR-MARNE",],
            ["nomChantier" => "Gymnase Lecuirot", "user" => "J.F", "client" => "MAISON NEUVE  ", "nChantier" => "22107", "adresse" => "28, Av. Joyeuse", "cp" => "94", "ville" => "VALENTON",],
            ["nomChantier" => "MAIRIE DE JOINVILLE", "user" => "", "client" => "BRIAND  ", "nChantier" => "22108", "adresse" => "14 Av. du Président Wilson", "cp" => "94", "ville" => "VILLIERS SUR MARNE",],
            ["nomChantier" => "Maison Mr et Mme NGUYEN ", "user" => "", "client" => "Inter Isolation  ", "nChantier" => "22109", "adresse" => "23  RUE DE PARIS", "cp" => "94", "ville" => "SAINT-MAUR-DES-FOSSES",],
            ["nomChantier" => "La poste", "user" => "JEREMY", "client" => "Inter Isolation  ", "nChantier" => "22110", "adresse" => "4 rue du Midi", "cp" => "94", "ville" => "SAINT-MAUR-DES-FOSSES",],
            ["nomChantier" => "Parc de la Plage Bleue", "user" => "", "client" => "GEC IDF  ", "nChantier" => "22111", "adresse" => "12, Boulevard du Général Gallieni", "cp" => "75", "ville" => "PARIS",],
            ["nomChantier" => "Siège", "user" => "DAVID", "client" => "GEC IDF  ", "nChantier" => "22112", "adresse" => "29 Avenue de la Plage Bleue", "cp" => "94", "ville" => "FONTENAY SOUS BOIS",],
            ["nomChantier" => "Ecole Maternelle Schaken : Phase 1", "user" => "", "client" => "LES NOUVEAUX CONSTRUCTEURS  ", "nChantier" => "22113", "adresse" => "351, Impasse des Armoiries", "cp" => "77", "ville" => "COMBS LA VILLE",],
            ["nomChantier" => "Ecole Maternelle Schaken : Phase 2 ", "user" => "QUENTIN", "client" => "VERRECCHIA  ", "nChantier" => "22114", "adresse" => "5 bis rue des Iles", "cp" => "92", "ville" => "CLAMART",],
            ["nomChantier" => "ECOLE SIBELLE", "user" => "", "client" => "MAISON NEUVE  ", "nChantier" => "22115", "adresse" => "5 bis rue des Iles", "cp" => "94", "ville" => "JOINVILLE LE PONT",],
            ["nomChantier" => "ATELIERS DE FONTENAY", "user" => "JEREMY", "client" => "HORS D'EAU  ", "nChantier" => "22116", "adresse" => "13 Avenue de la Sibelle", "cp" => "92", "ville" => "CHATILLON",],
            ["nomChantier" => "SNC LNC BETA PROMOTION", "user" => "", "client" => "TELAMON", "nChantier" => "22117", "adresse" => "46, Rue des Rieux", "cp" => "77", "ville" => "MONTEVRAIN",],
            ["nomChantier" => "Le Domaine de Breuil", "user" => "JEREMY", "client" => "HORS D'EAU  ", "nChantier" => "22118", "adresse" => "Route de Brie Compte Robert – Rue du Breuil", "cp" => "78", "ville" => "MONTESSON",],
            ["nomChantier" => "Ilot 17 - Beaurivage", "user" => "", "client" => "BRIAND  ", "nChantier" => "22119", "adresse" => "ZAC du Panorama - T2 - Boulevard du Moulin de la Tour - Allée Paulette Nardal", "cp" => "94", "ville" => "SAINT MAUR DES FOSSE",],

        ];
        /*    foreach ($data as $key => $val) {
                   if(!empty($societeRepository->findOneBySiret($key))){
                       $societeRepository->remove($societeRepository->findOneBySiret($key));
                   };
                   $user = $userRepository->findOneByPseudo($val['user']);
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
                   $societe->setRaisonSociale($val['client']);
                   $interlocuteur->setSociete($societe);
                   $interlocuteurRepository->add($interlocuteur);
                   $demande = new Demande();

                   $demande->setNomChantier($val['nomChantier']);
                   $demande->setReference($val['nChantier']);
                   $demande->setClient($interlocuteur);
                   $demande->setDate(date('d/m/Y'));

                   empty($user) ? $demande->setCreateur($this->getUser()) : $demande->setCreateur($user);
                  // $demande->setStatut($val['statut']);
                   $demande->setAdresse1($val['adresse']);
                   $demande->setVille($val['ville']);
                   $demande->setCodePostal($val['cp']);
                   $demande->setPays('France');



                   $demandeRepository->add($demande);
                   $interlocuteurRepository->add($interlocuteur);

               }           */
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
        } elseif (str_contains($route, 'interlocuteur/interlocuteur/client')) {
            $interlocuteur->setRoles(['ROLE_CLIENT']);
        } elseif (str_contains($route, 'interlocuteur/interlocuteur/transporteurs')) {
            $interlocuteur->setRoles(['ROLE_TRANSPORTEUR']);
        } elseif (str_contains($route, 'interlocuteur/interlocuteur/fournisseurs')) {
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
    public function show(Request $request, Interlocuteur $interlocuteur, RibRepository $ribRepository, FichierRepository $fichierRepository, SluggerInterface $slugger, DemandeRepository $demandeRepository): Response
    {


        $fichier = new Fichier();
        $demamndes = $demandeRepository->findAllDemande($interlocuteur->getId());

        $rib = new Rib();
        $rib->setInterlocuteur($interlocuteur);
        $formRIB = $this->createForm(RibType::class, $rib);
        $formRIB->handleRequest($request);

        if ($formRIB->isSubmitted() && $formRIB->isValid()) {
            $ribRepository->add($rib, true);
            return $this->redirectToRoute('app_interlocuteur_interlocuteur_show', ['id' => $interlocuteur->getId()]);
        }

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
            'formRIB' => $formRIB->createView(),
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
