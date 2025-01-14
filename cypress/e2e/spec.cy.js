describe('Test log in and log out features', () => {
  // If correct credentials are entered the user can log in

  it('User can log in successfully with the correct credentials', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/index.php');
    cy.get('#userDropdown').click();
    cy.get('.dropdown-item').contains('Log In').click();
    cy.get('input[name="email"]').type('admin@gmail.com');
    cy.get('input[name="pass"]').type('Password1');
    cy.get('input[value="Log in"]').click();
    cy.get('.logged-username').should('have.text', 'Hi, Shop!');
  });

  // User can log out successfully

  it('User can log out successfully', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/index.php');
    cy.get('#userDropdown').click();
    cy.get('.dropdown-item').contains('Log In').click();
    cy.get('input[name="email"]').type('admin@gmail.com');
    cy.get('input[name="pass"]').type('Password1');
    cy.get('input[value="Log in"]').click();
    cy.get('#userDropdown').click();
    cy.get('.dropdown-item').contains('Log Out').click();
    cy.get('.logged-username').should('have.text', 'Welcome!');
  });
});

describe('Test website navigation', () => {
  // shop page loads successfully

  it('From homepage user can access the shop section from the hamburger menu', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/index.php');
    cy.get('button').contains('☰').click();
    cy.get('.dropdown-item').contains('Shop').click();
    cy.url('http://localhost/codespace-ecommerce/public/session_cart.php');
  });

  // if item is added to the cart clicling "my cart" loads the cart page

  it('User can add items to cart and get to the cart page clicking the link in the modal', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/session_cart.php');
    cy.get('.card-img-top').first().click();
    cy.get('a').contains('Add to bag').click();
    cy.get('a').contains('View Your Cart').click();
    cy.url('http://localhost/codespace-ecommerce/public/cart.php');
  });
});

describe('Test cart features', () => {
  // if you open a product page and click "add to bag" the correct item is displayed

  it('The correct item is added to the cart', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/session_cart.php');
    cy.get('.card-img-top').first().click();
    cy.get('a').contains('Add to bag').click();
    cy.get('a').contains('View Your Cart').click();
    cy.get('h4').should('have.text', 'Acrasia');
  });

  // when user is not logged in if tries to checkout they get redirected to the log in page

  it('If user is logged out, in order to checkout user is forced to log in', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/session_cart.php');
    cy.get('.card-img-top').first().click();
    cy.get('a').contains('Add to bag').click();
    cy.get('a').contains('View Your Cart').click();
    cy.get('a').contains('Checkout Now').click();
    cy.url('http://localhost/codespace-ecommerce/public/login.php');
  });

  // changing quantity to 0 removes the item

  it('Changing quantity to 0 and updating the cart removes the item successfully', () => {
    cy.visit('http://localhost/codespace-ecommerce/public/session_cart.php');
    cy.get('.card-img-top').first().click();
    cy.get('a').contains('Add to bag').click();
    cy.get('a').contains('View Your Cart').click();
    cy.get('input[type="number"]').type('{backspace}0');
    cy.get('input[value="Update My Cart"]').click();
    cy.get('p').should('have.text', 'Your cart is currently empty');
  });
});
