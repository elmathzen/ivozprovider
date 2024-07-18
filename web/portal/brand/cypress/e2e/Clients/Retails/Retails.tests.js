import CompaniesItem from '../../../fixtures/Provider/Companies/Retails/getItem.json';
import newCompanies from '../../../fixtures/Provider/Companies/Retails/post.json';
import editCompanies from '../../../fixtures/Provider/Companies/Retails/put.json';
import { MODE, testPbx } from '../utils/PbxsValidator';

export const postCompany = () => {
  cy.usePactIntercept(
    {
      method: 'POST',
      url: '**/api/brand/companies*',
      response: newCompanies.response,
      matchingRules: newCompanies.matchingRules,
    },
    'createRetailCompanies'
  );

  cy.get('[aria-label=Add]').click();

  testPbx({ ...newCompanies, mode: MODE.NEW });

  cy.get('header').should('contain', 'Retails');

  cy.usePactWait(['createRetailCompanies'])
    .its('response.statusCode')
    .should('eq', 201);
};
export const putCompany = () => {
  cy.usePactIntercept(
    {
      method: 'GET',
      url: '**/api/brand/companies/3',
      response: { ...CompaniesItem },
    },
    'getRetailCompanies-3'
  );

  cy.usePactIntercept(
    {
      method: 'PUT',
      url: `**/api/brand/companies/${editCompanies.response.body.id}`,
      response: editCompanies.response,
    },
    'editRetailCompanies'
  );

  cy.get('svg[data-testid="EditIcon"]').eq(3).click();

  testPbx({ ...editCompanies, mode: MODE.EDIT });

  cy.get('header').should('contain', 'Retails');

  cy.usePactWait(['editRetailCompanies'])
    .its('response.statusCode')
    .should('eq', 200);
};

export const deleteCompany = () => {
  cy.contains('Retails').click();

  cy.get('td button svg[data-testid="MoreHorizIcon"]').first().click();
  cy.get('li.MuiMenuItem-root').contains('Delete').click();

  cy.contains('Remove element');
  cy.get('div.MuiDialog-container button')
    .filter(':visible')
    .contains('Yes, delete it')
    .click({ force: true });

  cy.get('header').should('contain', 'Retails');
};
