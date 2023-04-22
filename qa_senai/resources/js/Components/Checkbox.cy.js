import Checkbox from './Checkbox.vue'

describe('<Checkbox />', () => {
  it('renders', () => {
    // see: https://on.cypress.io/mounting-vue
    cy.mount(Checkbox)
  })
})