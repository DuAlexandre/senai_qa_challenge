import ApplicationLogo from './ApplicationLogo.vue'

describe('<ApplicationLogo />', () => {
  it('renders', () => {
    // see: https://on.cypress.io/mounting-vue
    cy.mount(ApplicationLogo)
  })
})