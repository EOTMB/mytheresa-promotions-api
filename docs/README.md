# Explanations and decisions

## Explanations

The API was developed with Hexagonal architecture, with PHP 8.2 and Symfony 7 to be able to take advantages of the 
DependencyInjection, the Routing module and the Doctrine ORM among other things. The infrastructure was implemented
using Docker to keep each service inside a container and docker compose to orchestate them in my local enviroment.
I organized the commands and the steps of the build using make


## Decisions

- The Product data was modelled as an entity, with each property encapsulated in its own value object to be able to
encapsulate the logic for each field
- The data was loading using Data Fixtures to populate a MySQL database.
- The endpoint was implemented with one controller, using the ADR pattern, where the DTO for the application service
is created from the http request and then used to call the ProductSearcher service
- The ProductSearcher queries the database using the ProductRepository, filtering according to the criterias specified
  (category and/or priceLessThan). Then it calls the DiscountCalculator domain service, that checks what discount should be
applied according to the specifications defined for each one, and then determines which discount should be applied to the product
- Finally, to enrich the domain model, i decided to keep the application of the discount in the value object, which calls the value object
to show the value of the discount.
- This general logic was adapted due to the small number of discount specifications. If this grows, or this wants to be managed dinamically through and administrator,
some decisions should be reviewed
- The results then are returned to the controller through another DTO. If no results are found, an exception is thrown indicating this. I wanted to add proper error mapping
to requests but time was up