stepcarousel.setup({
galleryid: 'mygallery', //id of carousel DIV
beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
panelclass: 'panel', //class of panel DIVs each holding content
panelbehavior: {speed:1000, wraparound:false, persist:true},
autostep: {enable:false, moveby:6, pause:10000},
defaultbuttons: {enable: true, moveby: 6, leftnav: ['/html/images/butt-left.png', 0, 64], rightnav: ['/html/images/butt-right.png', -11, 64]},
statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
contenttype: ['inline'], //content setting ['inline'] or ['external', 'path_to_external_file']
oninit:function(){
isloaded=false
document.getElementById('displaycssbelt').style.visibility="visible";
//document.getElementById('stocklevels').style.visibility="visible";
}
})