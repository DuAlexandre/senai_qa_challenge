const { defineConfig } = require("cypress");

module.exports = defineConfig({
  projectId: 'fb6pyw',
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
  },

  component: {
    devServer: {
      framework: "vue",
      bundler: "vite",
    },
  },
});
