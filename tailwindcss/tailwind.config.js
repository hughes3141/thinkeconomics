module.exports = {
  content: [
    "../index.php",
    "../header_tailwind.php",
    "../news.php",
    "../notes.php",
    "../exercises.php",
    "../footer_tailwind.php",
    "../mcq.php",
    "../admin.php",
    "../user_login2.0.php",
    "../login.php",


    "../node_modules/flowbite/**/*.js"

  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
],
}
