<head>
  <meta charset="utf-8"/>
  <title>Dashboard I Admin Panel</title>
  
  <link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
  <!--[if lt IE 9]>
  <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
  <script src="js/hideshow.js" type="text/javascript"></script>
  <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/jquery.equalHeight.js"></script>
  <script type="text/javascript">
  $(document).ready(function() 
      { 
          $(".tablesorter").tablesorter(); 
     } 
  );
  $(document).ready(function() {

  //When page loads...
  $(".tab_content").hide(); //Hide all content
  $("ul.tabs li:first").addClass("active").show(); //Activate first tab
  $(".tab_content:first").show(); //Show first tab content

  //On Click Event
  $("ul.tabs li").click(function() {

    $("ul.tabs li").removeClass("active"); //Remove any "active" class
    $(this).addClass("active"); //Add "active" class to selected tab
    $(".tab_content").hide(); //Hide all tab content

    var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
    $(activeTab).fadeIn(); //Fade in the active ID content
    return false;
  });

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>

</head>


<body>

  <header id="header">
    <hgroup>
      <h1 class="site_title"><a href="index.html">Website Admin</a></h1>
      <h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div>
    </hgroup>
  </header> <!-- end of header bar -->
  
  <section id="secondary_bar">
    <div class="user">

    </div>
    <div class="breadcrumbs_container">
      <article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
    </div>
  </section><!-- end of secondary bar -->
  
  <?php include"option.php"; ?>
  
  <section id="main" class="column"><!-- end of stats article --><!-- end of content manager article --><!-- end of messages article -->
    
    <div class="clear"></div>
    
    <article class="module width_full">
      <header><h3>Tambah Data Employee</h3></header>
        <div class="module_content">
          <form action = "create.php" method = "post">
                <fieldset>
                  NAMA 
                  <input type = "text" name="name"required="required">
                </fieldset>

                 <fieldset>
                  No. HP 
                  <input type = "text" name="mobile_phone"required="required">
                </fieldset>
                </div>
        
            <footer>

              <div class="submit_link">
                
                <input type="submit" value="SAVE" class="alt_btn">
            </form>
              </div>
                    

              
    

