
$("#paisC").change(function(){
if (document.getElementById('paisC').checked==true)
  {
    paisIniOn();
  }else{ paisIniOff(); };

});

$("#regionC").change(function(){
if (document.getElementById('regionC').checked==true)
  {
    regionIniOn();
  }else{ regionIniOff(); };

});

$("#zonaC").change(function(){
if (document.getElementById('zonaC').checked==true)
  {
    zonasIniOn();
  }else{ zonasIniOff(); };

});

$("#municipioC").change(function(){
if (document.getElementById('municipioC').checked==true)
  {
    municipioIniOn();
  }else{ municipioIniOff(); };

});

$("#puntosC").change(function(){
if (document.getElementById('puntosC').checked==true)
  {
    puntosIniOn();
  }else{ puntosIniOff(); };

});

setTimeout(paisIniOn, 2000); 
setTimeout(regionIniOn, 2000);  
setTimeout(zonasIniOn, 2000);  
setTimeout(puntosIniOn, 2000);
setTimeout(municipioIniOn, 2000);
