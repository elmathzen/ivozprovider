import DestinationRates from '../../../fixtures/Provider/DestinationRates/getCollection.json';
import postItem from '../../../fixtures/Provider/DestinationRates/postItem.json';

describe('in Destination Rates', () => {
  beforeEach(() => {
    cy.prepareGenericPactInterceptors('DestinationRates');
    cy.before();

    cy.get('svg[data-testid="WalletIcon"]').first().click();
    cy.contains('Destination rates').click();

    cy.get('header').should('contain', 'Destination rates');

    cy.get('table').should('contain', DestinationRates.body[0].name.en);
  });

  it('add desatination rate', () => {
    cy.usePactIntercept(
      {
        method: 'POST',
        url: '**/desatination_rates_group/',
        response: postItem.response,
      },
      'postDestinationPlan'
    );
    cy.contains('Add').first().click();

    cy.get('header').should('contain', 'New');
    cy.fillTheForm(postItem.request.body);

    cy.usePactWait(['postDestinationPlan']);
  });
});
