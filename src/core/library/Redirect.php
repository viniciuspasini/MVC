<?php

namespace core\library;

class Redirect
{
    public function __construct(private readonly Session $session)
    {
    }

    public function to(string $to = ""): Response
    {
        if($to === ""){
            return $this->to('/');
            die();
        }

        return new Response(
            status: 302,
            headers: [
                "Location" => $to,
            ]
        );
        die();
    }

    public function back(): Response
    {
        if(isset($_SERVER['HTTP_REFERER'])){
            return $this->to($_SERVER['HTTP_REFERER']);
            die;
        }
        return $this->to($this->session->get('url.last'));
        die;
    }

}