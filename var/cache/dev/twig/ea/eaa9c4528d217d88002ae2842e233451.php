<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* nav.html.twig */
class __TwigTemplate_062f6cb6b2643c92d9e3c4fc32ecbfdb extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "nav.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "nav.html.twig"));

        // line 1
        echo "<div class=\"sidebar-wrapper active ps ps--active-y\">
    <div class=\"sidebar-header\">
        <div class=\"d-flex justify-content-center\">
            <div class=\"logo\">
                <a href=\"";
        // line 5
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_home");
        echo "\"><img src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("uploads/logo/j4r_logo.png"), "html", null, true);
        echo "\" alt=\"Logo\" srcset=\"\"></a>
            </div>
            <div class=\"toggler\">
                <a href=\"#\" class=\"sidebar-hide d-xl-none d-block\"><i class=\"bi bi-x bi-middle\"></i></a>
            </div>
        </div>
    </div>
    <div class=\"sidebar-menu\">
        <ul class=\"menu\">
            <li class=\"sidebar-title\">Menu</li>

            <li class=\"sidebar-item ";
        // line 16
        echo (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 16, $this->source); })()), "request", [], "any", false, false, false, 16), "get", [0 => "_route"], "method", false, false, false, 16) == "app_home")) ? ("active") : (""));
        echo "\">
                <a href=\"";
        // line 17
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_home");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-grid-fill\"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class=\"sidebar-title\">Societé</li>

            <li class=\"sidebar-item\">
                <a href=\"";
        // line 26
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_interlocuteur_interlocuteur_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-list-ul\"></i>
                    <span>Liste</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-person-lines-fill\"></i>
                    <span>Contact</span>
                </a>
            </li>

            <li class=\"sidebar-title\">GED</li>

            <li class=\"sidebar-item  \">
                <a href=\"";
        // line 41
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_ged_fichier_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-folder2-open\"></i>
                    <span>Fichiers</span>
                </a>
            </li>
            <li class=\"sidebar-item  \">
                <a href=\"";
        // line 47
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_ged_type_fichier_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-folder2-open\"></i>
                    <span>Type de documents</span>
                </a>
            </li>
            <li class=\"sidebar-title\">Affaires</li>

            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-list-ul\"></i>
                    <span> Liste </span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Forecasts</span>
                </a>
            </li>


            <li class=\"sidebar-title\">Work</li>

            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-clock-history\"></i>
                    <span> YTD </span>
                </a>
            </li>
            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span> Objectifs </span>
                </a>
            </li>
            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-graph-up-arrow\"></i>
                    <span> Statistiques </span>
                </a>
            </li>

            <li class=\"sidebar-title\">Utilisateur</li>

            <li class=\"sidebar-item\">
                <a href=\"";
        // line 92
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_user_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-list-ul\"></i>
                    <span> Liste </span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"";
        // line 98
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_user_poste_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Postes</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"";
        // line 104
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_user_service_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"";
        // line 110
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_entite_entite_index");
        echo "\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Entité</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>LOGS</span>
                </a>
            </li>
        </ul>
    </div>
</div>
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    public function getTemplateName()
    {
        return "nav.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  183 => 110,  174 => 104,  165 => 98,  156 => 92,  108 => 47,  99 => 41,  81 => 26,  69 => 17,  65 => 16,  49 => 5,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"sidebar-wrapper active ps ps--active-y\">
    <div class=\"sidebar-header\">
        <div class=\"d-flex justify-content-center\">
            <div class=\"logo\">
                <a href=\"{{path('app_home')}}\"><img src=\"{{ asset('uploads/logo/j4r_logo.png')}}\" alt=\"Logo\" srcset=\"\"></a>
            </div>
            <div class=\"toggler\">
                <a href=\"#\" class=\"sidebar-hide d-xl-none d-block\"><i class=\"bi bi-x bi-middle\"></i></a>
            </div>
        </div>
    </div>
    <div class=\"sidebar-menu\">
        <ul class=\"menu\">
            <li class=\"sidebar-title\">Menu</li>

            <li class=\"sidebar-item {{ app.request.get('_route') == 'app_home' ? 'active' }}\">
                <a href=\"{{path('app_home')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-grid-fill\"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class=\"sidebar-title\">Societé</li>

            <li class=\"sidebar-item\">
                <a href=\"{{path('app_interlocuteur_interlocuteur_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-list-ul\"></i>
                    <span>Liste</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-person-lines-fill\"></i>
                    <span>Contact</span>
                </a>
            </li>

            <li class=\"sidebar-title\">GED</li>

            <li class=\"sidebar-item  \">
                <a href=\"{{path('app_ged_fichier_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-folder2-open\"></i>
                    <span>Fichiers</span>
                </a>
            </li>
            <li class=\"sidebar-item  \">
                <a href=\"{{path('app_ged_type_fichier_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-folder2-open\"></i>
                    <span>Type de documents</span>
                </a>
            </li>
            <li class=\"sidebar-title\">Affaires</li>

            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-list-ul\"></i>
                    <span> Liste </span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Forecasts</span>
                </a>
            </li>


            <li class=\"sidebar-title\">Work</li>

            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-clock-history\"></i>
                    <span> YTD </span>
                </a>
            </li>
            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span> Objectifs </span>
                </a>
            </li>
            <li class=\"sidebar-item\">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-graph-up-arrow\"></i>
                    <span> Statistiques </span>
                </a>
            </li>

            <li class=\"sidebar-title\">Utilisateur</li>

            <li class=\"sidebar-item\">
                <a href=\"{{path('app_user_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-list-ul\"></i>
                    <span> Liste </span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"{{path('app_user_poste_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Postes</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"{{path('app_user_service_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"{{ path('app_entite_entite_index')}}\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>Entité</span>
                </a>
            </li>
            <li class=\"sidebar-item \">
                <a href=\"#\" class=\"sidebar-link\">
                    <i class=\"bi bi-stack\"></i>
                    <span>LOGS</span>
                </a>
            </li>
        </ul>
    </div>
</div>
", "nav.html.twig", "/home/ouss/crm_j4r/templates/nav.html.twig");
    }
}
