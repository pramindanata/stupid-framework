module.exports = {
  env: {
    browser: true,
    es6: true
  },
  extends: [
    'standard',
    'prettier',
  ],
  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly'
  },
  parserOptions: {
    ecmaVersion: 2018,
    sourceType: 'module'
  },
  plugins: ['prettier'],
  rules: {
    'prefer-const': 2,
    'no-console': 1,
    'no-var': 2,
    'prettier/prettier': ['error']
  }
}
