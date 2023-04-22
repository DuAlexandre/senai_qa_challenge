import DangerButton from './DangerButton.vue'

describe('<DangerButton />', () => {
  it('renders', () => {
    // see: https://on.cypress.io/mounting-vue
    cy.mount(DangerButton)
  })
})