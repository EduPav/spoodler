<?php

// namespace classes\api\legacy\render;

// use classes\api\legacy\control\Renderable;
// use Twig\Environment;
// use classes\api\legacy\ApiResponse;
// use classes\api\response\Header;

// class Html implements Renderable {

//     private $twig;
//     private $successTemplate;
//     private $header;

//     function __construct(string $successTemplate, Environment $twig, Header $header) {
//         $this->successTemplate = $successTemplate;
//         $this->header = $header;
//         $this->header->set(HTML_CONTENT);
//         $this->twig = $twig;
//     }

//     function renderSuccess(ApiResponse $response): string {
//         return $this->twig->render($this->successTemplate, $response->getData());
//     }

//     function renderError(ApiResponse $response): string {
//         $context = ["exceptionMessage" => $response->getMessage()];
//         return $this->twig->render(ERROR_TEMPLATE, $context);
//     }

//     function renderNotFound(ApiResponse $response): string {
//         $this->header->set($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
//         $context = [
//             "mainMenu" => ["sections" => ["Go home" => "/"]],
//             "message" => $response->getMessage()
//         ];
//         return $this->twig->render(NOT_FOUND_TEMPLATE, $context);
//     }
// }
