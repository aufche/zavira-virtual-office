<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
     <link href="https://fonts.googleapis.com/css?family=Livvic&display=swap" rel="stylesheet">
    <style type="text/css">
        /*.bg{
            background-image:url(<?php echo asset('images/garansi.jpg');?>);
            background-repeat:no-repeat;
            width:1240px;
            height:1748px;
            margin-top:0px;
        }
        .content{
            padding-top:480px;
            line-height:35px;
        }
        */

        body {
  background: rgb(204,204,204); 
  font-family: 'Livvic', sans-serif;
  
}
page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  
}
page[size="A6"] {  
  width: 10cm;
  height: 15cm; 
  background-image:url(<?php echo asset('images/garansi.jpg');?>);
  background-size: contain;
}
page[size="A4"] {  
  width: 21cm;
  height: 29.7cm; 
}
page[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;  
}
page[size="A3"] {
  width: 29.7cm;
  height: 42cm;
}
page[size="A3"][layout="landscape"] {
  width: 42cm;
  height: 29.7cm;  
}
page[size="A5"] {
  width: 14.8cm;
  height: 21cm;
}
page[size="A5"][layout="landscape"] {
  width: 21cm;
  height: 14.8cm;  
}
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
  }
}
    </style>
  </head>
  <body>

  <page size="A6">
    <br /><br /><br /><br /><br /><br /><br />
    <div style="padding-left:80px;font-size:20px"><?php echo $data->nama;?></div><br />
    <div style="padding-left:140px;font-size:20px;"><?php echo $data->nohp;?></div><br />
    <div style="padding-left:140px;font-size:20px;margin-bottom:10px"><?php echo $data->id;?></div><br />
    <div style="padding-left:90px;font-size:20px;"><?php echo date('d F Y');?></div>
  </page>
         
  </body>
</html>