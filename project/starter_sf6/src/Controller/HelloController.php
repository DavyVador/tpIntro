<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class HelloController extends AbstractController
{
    #[Route("/helloRandom")]
    public function randomNameAction(): Response
    {
        return new Response(
            "<html><body><h1>Hello " .
            self::generateRandomName() .
            "</h1></body></html>"
        );
    }

    static function generateRandomName(): string
    {
        $nouns = [
            "Circle","Cone","Cylinder","Ellipse","Hexagon",
            "Irregular Shape","Octagon","Oval","Parallelogram",
            "Pentagon","Pyramid","Rectangle","Semicircle","Sphere",
            "Square","Star","Trapezoid","Triangle","Wedge","Whorl",
        ];
        $adjectives = [
            "Amusing", "Athletic", "Beautiful", "Brave", "Careless",
            "Clever", "Crafty", "Creative", "Cute", "Dependable",
            "Energetic", "Famous", "Friendly", "Graceful", "Helpful",
            "Humble", "Inconsiderate", "Likable", "Mid  Class", "Outgoing",
            "Poor", "Practical", "Rich", "Sad", "Skinny", "Successful", "Thin",
            "Ugly", "Wealth",
        ];
        return $adjectives[array_rand($adjectives)] .
            " " .
            $nouns[array_rand($nouns)];
    }

    #[Route("/hello/{name}")]
    public function nameAction(Session $session, $name = ""): Response
    {
        if ($name == "") {
            if($session->has('name') AND $session->get('name') != ''){
                $name = $session->get('name');
            }
            else{
                $name = self::generateRandomName();
                $session->set('name',$name);
            }
        }

        $session->set('name', $name);

        dump($session->get('name'));
        return $this->render("hello.html.twig", ["name"=>$name]);

    }

}