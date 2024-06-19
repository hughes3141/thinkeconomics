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
    "../assign_create1.0.php",
    "../assignment_list.php",
    "../revision.php",
  

    "../user/**/*.{html,js,php}",

    "../revision/**/*.{html,js,php}",
    "../exercises/**/*.{html,js,php}",

    "../mcq/**/*.{html,js,php}",
    "../saq/**/*.{html,js,php}",
    "../admin/**/*.{html,js,php}",
    "../pastpapers/**/*.{html,js,php}",
    "../news/**/*.{html,js,php}",
    
    "../exercises2.php",

    "../node_modules/flowbite/**/*.js"

  ],
  theme: {
    extend: {},
  },
  plugins: [
    //require('flowbite/plugin')
],
}
