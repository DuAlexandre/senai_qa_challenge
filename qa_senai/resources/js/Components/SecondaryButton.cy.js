import SecondaryButton from './SecondaryButton.vue'

describe('<SecondaryButton />', () => {
  it('renders', () => {
    // see: https://on.cypress.io/mounting-vue
    cy.mount(SecondaryButton)
  })
})