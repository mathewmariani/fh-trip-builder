# fh-tripbuilder

This is an assesment for FlightHub.

Web Services to ​build and navigate trips​ for a single passenger using criteria such as departure locations, departure dates and arrival locations. 


## Repository Layout

*   `extras/` – Files not directly used by the web service.
*   `app/` - Web service and API.


## Getting Started

### Prerequisites

This API was built using PHP 7.3.29 and MySQL 5.7.

### Installation

```sh
npm run serve
```

or alternatively,

```sh
php -S localhost:8000 index.php
```

From here HTTP requests can be sent to the web service using Postman.

## Endpoints

| Method | URL           | Status |
|--------|---------------|--------|
| GET    | /airlines     | DONE   |
| GET    | /airports     | DONE   |
| GET    | /flights      | DONE   |
| GET    | /onewaytrip   | DONE   |
| GET    | /roundtrip    | DONE   |
| POST   | /airlines     | DONE   |
| POST   | /airports     | DONE   |
| POST   | /flights      | DONE   |
| DELETE | /airlines     | DONE   |
| DELETE | /airports     | DONE   |
| DELETE | /flights      | DONE   |