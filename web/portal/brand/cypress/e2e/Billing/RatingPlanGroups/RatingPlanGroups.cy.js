import RecordingPlanGroupCollection from '../../../fixtures/Provider/RatingPlanGroup/getCollections.json';
import postItem from '../../../fixtures/Provider/RatingPlanGroup/postItem.json';
import simulateCall from '../../../fixtures/Provider/RatingPlanGroup/postSimulateCall.json';
import putItem from '../../../fixtures/Provider/RatingPlanGroup/putItem.json';
import item1 from '../../../fixtures/Provider/RatingPlanGroup/getItem.json';

describe('in Rating Plan Group', () => {
  beforeEach(() => {
    cy.prepareGenericPactInterceptors('RatingPlanGroups');
    cy.before();

    cy.get('svg[data-testid="WalletIcon"]').first().click();
    cy.contains('Rating Plan Groups').click();

    cy.get('header').should('contain', 'Rating Plan Groups');

    cy.get('table').should(
      'contain',
      RecordingPlanGroupCollection.body[0].name['en']
    );
  });

  it('add Rating Plan Group', () => {
    cy.usePactIntercept(
      {
        method: 'POST',
        url: '**/rating_plan_groups/',
        response: postItem.response,
      },
      'postRatingPlanGroup'
    );

    cy.contains('Add').first().click();

    cy.get('header').should('contain', 'New');

    cy.fillTheForm(postItem.request);

    cy.contains('Save').first().click();
  });

  it('edit Rating Plan Group', () => {
    cy.usePactIntercept(
      {
        method: 'GET',
        url: '**/rating_plan_groups/1',
        response: item1.response,
      },
      'getRatingPlanGroup-1'
    );

    cy.usePactIntercept(
      {
        method: 'PUT',
        url: '**/rating_plan_groups/1',
        response: putItem.response,
      },
      'putRatingPlanGroup-1'
    );

    cy.get('table [data-testid="EditIcon"]').first().click();
    cy.usePactWait(['getRatingPlanGroup-1']);

    cy.fillTheForm(putItem.request);

    cy.usePactWait(['putRatingPlanGroup-1'])
      .its('response.statusCode')
      .should('eq', 200);
  });

  it('delete Rating Plan Group', () => {
    cy.usePactIntercept(
      {
        method: 'DELETE',
        url: '**/rating_plan_groups/1',
        response: {
          statusCode: 204,
        },
      },
      'deleteRatingPlanGroup-1'
    );

    cy.get('table [data-testid="DeleteIcon"]').first().click();

    cy.contains('Remove element');
    cy.get('div[role=dialog] button')
      .filter(':visible')
      .contains('Yes, delete it')
      .click();

    cy.usePactWait(['deleteRatingPlanGroup-1'])
      .its('response.statusCode')
      .should('eq', 204);
  });

  it('simulate call', () => {
    cy.usePactIntercept(
      {
        method: 'POST',
        url: '**/rating_plan_groups/1/simulate_call',
        response: simulateCall.response,
      },
      'postSimulatePactWait-1'
    );

    cy.intercept('**/rating_plan_groups/2/simulate_call', {});
    cy.get('.list-content-header [data-testid="MoreHorizIcon"]')
      .first()
      .click();

    cy.contains('Simulate call').first().click();

    cy.contains('Phone number')
      .siblings('.input-field')
      .clear()
      .type(simulateCall.request.number);

    cy.contains('Duration (seconds)')
      .siblings('.input-field')
      .clear()
      .type(simulateCall.request.duration);

    cy.contains('Accept').click();

    cy.usePactWait(['postSimulatePactWait-1'])
      .its('response.statusCode')
      .should('eq', 200);

    cy.get('table')
      .eq(1)
      .should('contain', simulateCall.response.body.callDate);
  });

  it('does something wiht money icon', () => {
      cy.usePactIntercept({
        method: 'GET',
        url: '**/rating_plans?*',
        response: {},
      }, 'ratingPlans');
      cy.get('table [data-testid="MoneyIcon"]').first().click();

      cy.get('header').should('contain', 'Destination rates-FAIL');
  });
});
