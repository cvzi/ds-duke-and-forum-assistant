// ==UserScript==
// @name          DS Search Internal Forum
// @description   Titel aller Threads im Internen Forum nach einem Schlüsselwort durchsuchen und Ergebnisse anzeigen, Threads können nach Autor farbig markiert werden, Gesamtes Forum als gelesen markieren, Ersetzen von Textsmilies z.B. :) durch Grafiken, Ersetzen von übergroßen Schriften, Verkleinern zu großer Bilder
// @namespace     example.com
// @include       http://*.die-staemme.de/forum.php*
// @exclude       http://forum.die-staemme.de/*
// ==/UserScript==


// {$ dsScript $}
// version = 0.4
// author = C1B1SE
// clients = firefox
// areas = .de
// worlds = all
// premium = works
// description[de] = Features: <br /> - Titel aller Threads im Internen Forum nach einem Schlüsselwort durchsuchen und Ergebnisse anzeigen<br /> - Threads können nach Autor farbig markiert werden<br /> - Gesamtes Forum als gelesen markieren<br /> - Ersetzen von Textsmilies z.B. :) durch Grafiken<br />r/> - Ersetzen von übergroßen Schriften<br /> - Verkleinern zu großer Bilder
// screenshot[0] = http://cuzi.c1.funpic.de/newhp_userscripts_screens/ds.searchIntForum_0.png
// screenshot[1] = http://cuzi.c1.funpic.de/newhp_userscripts_screens/ds.searchIntForum_1.png
// {$ /dsScript $}

// (c) by C1B1SE

// Do not republish, use in other scripts, change or reproduce without permission from C1B1SE

/*
  ToDo:
  - large font-sizes
  - large pics
  - colours (if doable)
  - search the whole thing
  - new threads on arrival page

  RAM:
  - String.fromCharCode(  );     // http://de.selfhtml.org/inter/unicode.htm | cmd -> charmap

*/


var dom = new html();

if(GM_getValue('search_active') == undefined)
  {
  // First Start Fill Config

  var a = dom.id('ds_body').getElementsByTagName('div')[0].getElementsByTagName('a')[0].href;
  // forum.php?screen=view_forum&forum_id=11111
  var baseURL = a.split('=');
  void baseURL.pop();
  baseURL = baseURL.join('=');
  baseURL += '=';


  GM_setValue('mark_all_read_active',false);
  GM_setValue('mark_all_read_links','');
  GM_setValue('search_active',false);
  GM_setValue('search_string','');
  GM_setValue('search_baseURL',baseURL);
  GM_setValue('search_ids','');
  GM_setValue('search_result','');
  GM_setValue('colourThreads',1);
  GM_setValue('colourThreadsNames','');
  GM_setValue('replaceSmiliesOn',true);
  GM_setValue('maxFontSize',20);
  GM_setValue('maxImgSize','300x250');

  alert('DS Search Internal Forum ist jetzt initialisiert!');
  document.location.reload();
  }

var replaceSmiliesOn = GM_getValue('replaceSmiliesOn')?true:false;
var search_active = GM_getValue('search_active')?true:false;
var mark_all_read_active = GM_getValue('mark_all_read_active')?true:false;
var colourThreadsVar = parseInt(GM_getValue('colourThreads'));   // 0 = off, 1 = textbox, 2 = namebar
var colourThreadsNames = GM_getValue('colourThreadsNames');
var maxFontSize = parseInt(GM_getValue('maxFontSize'));   // 0 > on
var maxImgSize = GM_getValue('maxImgSize')?GM_getValue('maxImgSize').split('x'):false; // false = off, split('x')[0,1]

var url = document.location.href;

var srcs = eval({
  "trash":"http://www.example.com/smile/dsforum/trash.gif",
  "edit":"http://www.example.com/smile/dsforum/edit.gif"
  });

var colours = new Array(
        "#FFEFAE", "#FFD7AE", "#FECDD7", "#F9CDFE", "#E3CDFE", "#D3D7FE", "#D3ECFE", "#D3FEFA", "#CFFED0", "#ECFEAF",
        "#FFE064", "#FFB66C", "#FD829A", "#F28EFD", "#C699FD", "#8B97FC", "#83C9FC", "#74FCEE", "#69FC6C", "#DEFD73",
        "#F4C400", "#F47A00",            "#E311FB", "#00ced1", "#1D33FA", "#0581DC", "#04C6B3", "#03A707", "#9CC903",
        "#AD966B", "#9E7A8B", "#AE6AA9", "#6B6398", "#6F8BAA", "#6DABAB", "#6BAD71",
        "#B79300", "#4F03AB", "#020F7D", "#034A7E", "#026258", "#014503", "#DFD9CE",
         "#660000", "#701a1a", "#7a3333", "#854d4d", "#8f6666", "#998080", "#a39999", "#adb3b3", "#b8cccc", "#c2e6e6",
         "#ccffff", "#ff0000", "#e60f00", "#cc1f00", "#b32e00", "#993d00", "#804d00", "#665c00", "#4d6b00", "#337a00",
         "#1a8a00", "#009900", "#ffcc00", "#e6c71a", "#ccc233", "#b3bd4d", "#99b866", "#80b380", "#66ad99", "#4da8b3",
         "#33a3cc", "#1a9ee6", "#0099ff", "#006600", "#007500", "#008500", "#009400", "#00a300", "#00b300", "#00c200",
         "#00d100", "#00e000", "#00f000", "#00ff00", "#99ff66", "#a3f075", "#ade085", "#b8d194", "#c2c2a3", "#ccb3b3",
         "#d6a3c2", "#e094d1", "#eb85e0", "#f575f0", "#ff66ff");


var smilies = eval({
  '^^':['img','http://www.example.com/smile/dsforum/grin.gif'],

  'xD':['img','http://www.example.com/smile/dsforum/biggrin.gif'],
  ':-D':['img','http://www.example.com/smile/dsforum/biggrin.gif'],
  ':D':['img','http://www.example.com/smile/dsforum/biggrin.gif'],
  '=D ':['img','http://www.example.com/smile/dsforum/biggrin.gif'],

  'lol':['img','http://www.example.com/smile/dsforum/lword.gif'],

  ':P':['img','http://www.example.com/smile/dsforum/tongue.gif'],
  ':-P':['img','http://www.example.com/smile/dsforum/tongue.gif'],
  '=P ':['img','http://www.example.com/smile/dsforum/tongue.gif'],
  'xP':['img','http://www.example.com/smile/dsforum/tongue.gif'],
  ';p':['img','http://www.example.com/smile/dsforum/tongue.gif'],


  ' 8)':['img','http://www.example.com/smile/dsforum/cool.gif'],
  '*cool*':['img','http://www.example.com/smile/dsforum/cool.gif'],

  '???':['img','http://www.example.com/smile/dsforum/questionMark.png'],

  ';)':['img','http://www.example.com/smile/dsforum/wink.gif'],
  ';-)':['img','http://www.example.com/smile/dsforum/wink.gif'],

  ';(':['img','http://www.example.com/smile/dsforum/cry.gif'],

  ':S':['img','http://www.example.com/smile/dsforum/undecided.gif'],

  ':|':['img','http://www.example.com/smile/dsforum/worried.gif'],

  ':(':['img','http://www.example.com/smile/dsforum/sad.gif'],
  ':-(':['img','http://www.example.com/smile/dsforum/sad.gif'],

  ':)':['img','http://www.example.com/smile/dsforum/classic.gif'],
  ':-)':['img','http://www.example.com/smile/dsforum/classic.gif'],

  '=)':['img','http://www.example.com/smile/dsforum/normal.gif']

  });

// Start it
load();


function load()
  {
  if(url.indexOf('screen=view_forum') != -1 && url.indexOf('forum_id') != -1  && search_active) // If we are in the search process
    {
    searchTitles();
    }
  else if(url.indexOf('screen=view_forum') != -1 && url.indexOf('forum_id') != -1  && mark_all_read_active)  // If we are in the 'mark all read' process
    {
    markAllRead();
    }
  else if(url.indexOf('screen=view_forum') != -1  && url.indexOf('forum_id') != -1  && !search_active) // If we are in a forum
    {
    bar();
    }
  else if(url.indexOf('screen=view_thread') != -1  && url.indexOf('thread_id') != -1 ) // If we are in a thread
    {
    // Order!
    colourThreads();
    scaleFontSize();
    scaleImgSize();
    replaceSmilies();
    }

  }

function dialog_membercolours()
  {

  var div = dom.n('div');
  div.id = 'dialog_membercolours';
  div.style.zIndex = 21;
  div.style.position = 'absolute';
  div.style.top = '10px';
  div.style.left = '200px';
  div.style.minHeight = '50px';
  div.style.minWidth = '150px';
  div.style.background = 'url(graphic/background/main.jpg) #F1EBDD';
  div.style.border = '3px outset #804000';
  div.style.borderTopColor = '#A0A0A0';

  var content = dom.n('table');
  content.setAttribute('id','dialog_membercolours_content');

  var tr = dom.n('tr');

  var th = dom.n('th');
  th.appendChild(dom.text(''));
  tr.appendChild(th);

  var th = dom.n('th');
  th.appendChild(dom.text('Member'));
  tr.appendChild(th);

  var th = dom.n('th');
  th.appendChild(dom.text('Farbe'));
  tr.appendChild(th);

  content.appendChild(tr);

  // Walk through the array
  var ar = colourThreadsNames.split(',');

  function sortV(a, b)
    {
    a = a.split('=')[1]
    ar = parseInt(a.substr(1,2),16);
    ag = parseInt(a.substr(3,2),16);
    ab = parseInt(a.substr(5,2),16);

    b = b.split('=')[1]
    br = parseInt(b.substr(1,2),16);
    bg = parseInt(b.substr(3,2),16);
    bb = parseInt(b.substr(5,2),16);

    if(ar > br)
      return 1;
    else if(ag > bg)
      return 1;
    else if(ab > bb)
      return 1;

    else if(ar < br)
      return -1;
    else if(ag < bg)
      return -1;
    else if(ab < bb)
      return -1;

    return 0;
    }

  ar = ar.sort(sortV);

  var names = new Array();
  for(var i = 0; i < ar.length; i++)
    {
    var sub = ar[i].split('=');
    if(sub[0] && sub[1])
      names[unescape(sub[0])] = sub[1];
    }

  for(var name in names)
    {
    var tr = dom.n('tr');

    var td = dom.n('td');
    var img = new Image();
    img.src = srcs['trash'];
    img.alt = 'Löschen';
    img.title = 'Löschen';
    dom.addEvent(img,'click',function(event)
      {
      var tr = dom.mouseEventTarget(event).parentNode.parentNode;

      var name = dom.mouseEventTarget(event).parentNode.nextSibling.firstChild.data;
      if(confirm('Soll '+name+' wirklich aus der Liste gelöscht werden?'))
        tr.parentNode.removeChild(tr);
      });
    td.appendChild(img);
    tr.appendChild(td);

    content.appendChild(tr);


    var td = dom.n('td');
    td.appendChild(dom.text(name));
    tr.appendChild(td);

    var td = dom.n('td');
    td.setAttribute('colspan',2);
    td.setAttribute('title',names[name]);
    td.setAttribute('style','background:'+names[name]+'; border:1px solid black; ');
    td.appendChild(dom.text(names[name]));
    dom.addEvent(td,'click',function(event)
      {
      var td = dom.mouseEventTarget(event);
      dom.removeChilds(td);

      var r = parseInt(td.title.substr(1,2),16);
      var g = parseInt(td.title.substr(3,2),16);
      var b = parseInt(td.title.substr(5,2),16);

      // R
      var select = dom.n('select');
      select.setAttribute('size',1);
      for(var i = 0; i < 255; i++)
        {
        var option = dom.n('option');
        option.setAttribute('value',i);
        option.appendChild(dom.text( i.toString(16).toUpperCase() ));
        if(i == r)
          option.setAttribute('selected','selected');
        select.appendChild(option);
        }
      td.appendChild(select);

      // G
      var select = dom.n('select');
      select.setAttribute('size',1);
      for(var i = 0; i < 255; i++)
        {
        var option = dom.n('option');
        option.setAttribute('value',i);
        option.appendChild(dom.text( i.toString(16).toUpperCase() ));
        if(i == g)
          option.setAttribute('selected','selected');
        select.appendChild(option);
        }
      td.appendChild(select);

      // B
      var select = dom.n('select');
      select.setAttribute('size',1);
      for(var i = 0; i < 255; i++)
        {
        var option = dom.n('option');
        option.appendChild(dom.text( i.toString(16).toUpperCase() ));
        if(i == b)
          option.setAttribute('selected','selected');
        select.appendChild(option);
        }
      td.appendChild(select);

      // OK
      var input = dom.n('input');
      input.setAttribute('type','button');
      input.setAttribute('value','ok');
      dom.addEvent(input,'click',function(event)
        {
        var td = dom.mouseEventTarget(event).parentNode;

        var r = td.getElementsByTagName('select')[0].options[td.getElementsByTagName('select')[0].selectedIndex].firstChild.data;
        var g = td.getElementsByTagName('select')[1].options[td.getElementsByTagName('select')[1].selectedIndex].firstChild.data;
        var b = td.getElementsByTagName('select')[2].options[td.getElementsByTagName('select')[2].selectedIndex].firstChild.data;

        td.title = '#'+String(r)+String(g)+String(b);
        dom.removeChilds(td);
        td.appendChild(dom.text(td.title));
        td.setAttribute('style','background:'+td.title+'; border:1px solid black; ');
        });
      td.appendChild(input);
      });

    tr.appendChild(td);
    content.appendChild(tr);

    }


  // Save Button
  var saveB = dom.n('input');
  saveB.setAttribute('value','Übernehmen');
  saveB.setAttribute('type','button');
  dom.addEvent(saveB,'click',function() { save_dialog_membercolours(); });

  // Cancel Button
  var cancelB = dom.n('input');
  cancelB.setAttribute('value','Abbrechen');
  cancelB.setAttribute('type','button');
  dom.addEvent(cancelB,'click',function() { if(confirm('Alle Änderungen gehen verloren\nWirklich abbrechen?')) dom.id('dialog_membercolours').parentNode.removeChild(dom.id('dialog_membercolours')); });

  // Titlebar
  var title = dom.n('div');
  title.id = 'dialog_statusbar';
  title.style.color = 'white';
  title.style.background = '#A0A0A0';
  title.style.zIndex = 22;
  title.style.textAlign = 'center';
  title.style.fontFamily = 'Verdana,sans-serif';

  title.appendChild(dom.text('Memberfarben'));

  var img = new Image();
  img.src = 'http://www.example.com/close.png';
  img.alt = 'Schließen';
  img.title = 'Schließen';
  img.style.position = 'absolute';
  img.style.left = '0px';
  img.style.top = '0px';
  dom.addEvent(img,'click',function() { dom.id('dialog_membercolours').parentNode.removeChild(dom.id('dialog_membercolours')); });
  title.appendChild(img);

  // Instructions
  var instructions = dom.n('p');
  instructions.appendChild(dom.text('Zum Verändern einer Farbe auf dieselbige klicken.'))

  // Scroll Box
  var scrollBox = dom.n('div');
  scrollBox.style.overflow = 'auto';
  scrollBox.style.maxHeight = (window.innerHeight-120)+'px';
  scrollBox.appendChild(content);

  div.appendChild(title);
  div.appendChild(instructions)
  div.appendChild(scrollBox);
  div.appendChild(saveB);
  div.appendChild(cancelB);

  dom.id('ds_body').appendChild(div);
  }

function save_dialog_membercolours()
  {
  var elist = dom.id('dialog_membercolours_content').getElementsByTagName('tr');

  var saveThing = new Array();
  for(var i = 1, len = elist.length; i < len; i++)
    {
    var name = escape(elist[i].getElementsByTagName('td')[1].firstChild.data);
    var colour = elist[i].getElementsByTagName('td')[2].title;
    void saveThing.push(name  + '=' + colour);
    }

  GM_setValue('colourThreadsNames',saveThing.join(','));

  alert('Gespeichert!');
  dom.id('dialog_membercolours').parentNode.removeChild(dom.id('dialog_membercolours'));
  document.location.reload();
  }



function dialog_settings()
  {

  var div = dom.n('div');
  div.id = 'dialog_settings';
  div.style.zIndex = 21;
  div.style.position = 'absolute';
  div.style.top = '100px';
  div.style.left = '200px';
  div.style.minHeight = '50px';
  div.style.minWidth = '150px';
  div.style.background = 'url(graphic/background/main.jpg) #F1EBDD';
  div.style.border = '3px outset #804000';
  div.style.borderTopColor = '#A0A0A0';

  var content = dom.n('table');

  var tr = dom.n('tr');
  var th = dom.n('th');
  th.setAttribute('colspan',2);
  th.appendChild(dom.text('Einstellungen'));
  tr.appendChild(th);
  content.appendChild(tr);


  // <-Colour Threads
  var tr = dom.n('tr');

  var td = dom.n('td');
  td.appendChild(dom.text('Threads kolorieren'));
  tr.appendChild(td);

  var select = dom.n('select');
  select.setAttribute('size','1');
  select.setAttribute('name','i_colourThreads');

  var option0 = dom.n('option');
  option0.setAttribute('value','0');
  option0.appendChild(dom.text('Aus'));
  if(colourThreadsVar == 0)
    option0.setAttribute('selected','selected');

  var option1 = dom.n('option');
  option1.setAttribute('value','1');
  option1.appendChild(dom.text('Textbox'));
  if(colourThreadsVar == 1)
    option1.setAttribute('selected','selected');

  var option2 = dom.n('option');
  option2.setAttribute('value','2');
  option2.appendChild(dom.text('Titel'));
  if(colourThreadsVar == 2)
    option2.setAttribute('selected','selected');

  dom.appendChilds(select,option0,option1,option2);

  var td = dom.n('td');
  td.appendChild(select);
  tr.appendChild(td);
  content.appendChild(tr);
  // Colour Threads->

  // <-Replace Smilies
  var tr = dom.n('tr');

  var td = dom.n('td');
  td.appendChild(dom.text('Smilies ersetzen'));
  tr.appendChild(td);

  var input = dom.n('input');
  input.setAttribute('value','true');
  input.setAttribute('type','checkbox');
  input.setAttribute('name','i_replaceSmilies');
  if(replaceSmiliesOn)
    input.setAttribute('checked','checked');

  var td = dom.n('td');
  td.appendChild(input);
  tr.appendChild(td);
  content.appendChild(tr);
  // Replace Smilies->

  // <-Scale Fontsize
  var tr = dom.n('tr');

  var td = dom.n('td');
  td.appendChild(dom.text('Maximale Schriftgröße'));
  tr.appendChild(td);

  var input = dom.n('input');
  input.setAttribute('value','true');
  input.setAttribute('type','checkbox');
  input.setAttribute('name','i_scaleFontsize');
  if(maxFontSize > 0)
    input.setAttribute('checked','checked');
  dom.addEvent(input,'click',function()
    {
    if(this.checked)
      dom.name('i_scaleFontsize_text')[0].removeAttribute('disabled',1);
    else
      dom.name('i_scaleFontsize_text')[0].setAttribute('disabled','disabled');
    });

  var input_text = dom.n('input');
  input_text.setAttribute('type','text');
  input_text.setAttribute('name','i_scaleFontsize_text');
  if(maxFontSize > 0)
    input_text.setAttribute('value',maxFontSize);
  else
    {
    input_text.setAttribute('value','');
    input_text.setAttribute('disabled','disabled');
    }
  var td = dom.n('td');
  td.appendChild(input);
  td.appendChild(dom.text(' '));
  td.appendChild(input_text);
  tr.appendChild(td);
  content.appendChild(tr);
  // Scale Fontsize->

  // <-Scale Imgagesize
  var tr = dom.n('tr');

  var td = dom.n('td');
  td.appendChild(dom.text('Maximale Bildgröße'));
  tr.appendChild(td);

  var input = dom.n('input');
  input.setAttribute('value','true');
  input.setAttribute('type','checkbox');
  input.setAttribute('name','i_maxImgSize');
  if(maxImgSize)
    input.setAttribute('checked','checked');
  dom.addEvent(input,'click',function()
    {
    if(this.checked)
      {
      dom.name('i_maxImgSize_width')[0].removeAttribute('disabled',1);
      dom.name('i_maxImgSize_height')[0].removeAttribute('disabled',1);
      }
    else
      {
      dom.name('i_maxImgSize_width')[0].setAttribute('disabled','disabled');
      dom.name('i_maxImgSize_height')[0].setAttribute('disabled','disabled');
      }
    });

  var input_width = dom.n('input');
  input_width.setAttribute('type','text');
  input_width.setAttribute('name','i_maxImgSize_width');
  if(maxImgSize)
    input_width.setAttribute('value',maxImgSize[0]);
  else
    {
    input_width.setAttribute('value','');
    input_width.setAttribute('disabled','disabled');
    }

  var input_height = dom.n('input');
  input_height.setAttribute('type','text');
  input_height.setAttribute('name','i_maxImgSize_height');
  if(maxImgSize)
    input_height.setAttribute('value',maxImgSize[1]);
  else
    {
    input_height.setAttribute('value','');
    input_height.setAttribute('disabled','disabled');
    }

  var td = dom.n('td');
  td.appendChild(input);
  td.appendChild(dom.text(' '));
  td.appendChild(input_width);
  td.appendChild(dom.text('x'));
  td.appendChild(input_height);
  td.appendChild(dom.text(' (Breite x Höhe)'));
  tr.appendChild(td);
  content.appendChild(tr);
  // Scale Imagesize->

  // Save Button
  var saveB = dom.n('input');
  saveB.setAttribute('value','Übernehmen');
  saveB.setAttribute('type','button');
  dom.addEvent(saveB,'click',function() { save_dialog_settings(); });

  // Cancel Button
  var cancelB = dom.n('input');
  cancelB.setAttribute('value','Abbrechen');
  cancelB.setAttribute('type','button');
  dom.addEvent(cancelB,'click',function() { if(confirm('Alle ungespeicherten Änderungen gehen verloren\nWirklich abbrechen?')) dom.id('dialog_settings').parentNode.removeChild(dom.id('dialog_settings')); });

  // Titlebar
  var title = dom.n('div');
  title.id = 'dialog_statusbar';
  title.style.color = 'white';
  title.style.background = '#A0A0A0';
  title.style.zIndex = 22;
  title.style.textAlign = 'center';
  title.style.fontFamily = 'Verdana,sans-serif';

  title.appendChild(dom.text('Einstellungen'));

  var img = new Image();
  img.src = 'http://www.example.com/close.png';
  img.alt = 'Schließen';
  img.title = 'Schließen';
  img.style.position = 'absolute';
  img.style.left = '0px';
  img.style.top = '0px';
  dom.addEvent(img,'click',function() { dom.id('dialog_settings').parentNode.removeChild(dom.id('dialog_settings')); });
  title.appendChild(img);

  // Instructions
  var instructions = dom.n('p');
  instructions.appendChild(dom.text('Allgemeine Einstellungen.'))

  div.appendChild(title);
  div.appendChild(instructions)
  div.appendChild(content);
  div.appendChild(saveB);
  div.appendChild(cancelB);

  dom.id('ds_body').appendChild(div);
  }


function save_dialog_settings()
  {
  // <-Colour Threads
  var select = dom.name('i_colourThreads')[0];
  colourThreadsVar = parseInt(select.options[select.selectedIndex].value);
  GM_setValue('colourThreads',colourThreadsVar);
  // Colour Threads->

  // <-Replace Smilies
  replaceSmiliesOn = dom.name('i_replaceSmilies')[0].checked?true:false;
  GM_setValue('replaceSmiliesOn',true);
  // Replace Smilies->

  // <-Scale Fontsize
  if(dom.name('i_scaleFontsize')[0].checked)
    GM_setValue('maxFontSize',dom.name('i_scaleFontsize_text')[0].value);
  else
    GM_setValue('maxFontSize',0);
  // Scale Fontsize->

  // <-Scale Imgagesize
  if(dom.name('i_maxImgSize')[0].checked)
    GM_setValue('maxImgSize',dom.name('i_maxImgSize_width')[0].value+'x'+dom.name('i_maxImgSize_height')[0].value);
  else
    GM_setValue('maxImgSize',false);
  // Scale Imagesize->



  alert('Gespeichert!');
  dom.id('dialog_settings').parentNode.removeChild(dom.id('dialog_settings'));
  document.location.reload();
  }

function menu_extras()
  {
  if(dom.id('menu_extras'))
    {
    table = dom.id('menu_extras');
    table.style.display = 'block';
    }
  else
    {
    var table = dom.n('table');
    table.setAttribute('id','menu_extras');
    table.style.top = dom.id('link_menu_extras').offsetTop + 'px';
    table.style.left = dom.id('link_menu_extras').offsetLeft + 'px';
    table.style.backgroundColor = '#DED3B9';
    table.style.border = '#DED3B9 outset 3px';
    table.style.borderTop = '0px';
    table.style.borderLeft = '0px';
    table.style.position = 'absolute';

    var tr = dom.n('tr');
    var td = dom.n('td');
    var a = dom.n('a');
    a.href = '#';
    a.appendChild(dom.text('Einstellungen'));
    dom.addEvent(a,'click',function() { dom.id('menu_extras').style.display = 'none'; dialog_settings(); });
    td.appendChild(a);
    tr.appendChild(td);
    table.appendChild(tr);

    var tr = dom.n('tr');
    var td = dom.n('td');
    var a = dom.n('a');
    a.href = '#';
    a.appendChild(dom.text('Memberfarben'));
    dom.addEvent(a,'click',function() { dom.id('menu_extras').style.display = 'none'; dialog_membercolours(); });
    td.appendChild(a);
    tr.appendChild(td);
    table.appendChild(tr);

    var tr = dom.n('tr');
    var td = dom.n('td');
    var a = dom.n('a');
    a.href = '#';
    a.appendChild(dom.text('Über DS Search Internal Forum'));
    dom.addEvent(a,'click',function(){ dom.id('menu_extras').style.display = 'none'; alert('DS Search Internal Forum\n    (c) by C1B1SE 2008\ncuzi@openmail.cc\nhttp://example.com'); });
    td.appendChild(a);
    tr.appendChild(td);
    table.appendChild(tr);

    dom.id('ds_body').appendChild(table);
    }

  }

function scaleFontSize()
  {
  if(maxFontSize <= 0)
    return false;

  var elist = dom.class('text');
  for(var i = 0; i < elist.length; i++)
    {

    var nodeElements = elist[i].getElementsByTagName('*');
    for(var x = 0; x < nodeElements.length; x++)
      {
      if(nodeElements[x].style)
        {
        if(nodeElements[x].style.fontSize)
          {
          if(parseInt(nodeElements[x].style.fontSize) > maxFontSize)
            {
            nodeElements[x].title = 'Schriftgröße von '+parseInt(nodeElements[x].style.fontSize)+' auf '+maxFontSize+' reduziert';
            nodeElements[x].style.fontSize = maxFontSize+'pt';
            }
          }
        }
      }

    }

  }

function scaleImgSize()
  {
  if(maxImgSize == false)
    return false;

  var elist = dom.class('text');
  for(var i = 0; i < elist.length; i++)
    {
    var imgs = elist[i].getElementsByTagName('img');
    for(var x = 0; x < imgs.length; x++)
      {
      imgs[x].style.maxWidth = maxImgSize[0]+'px';
      imgs[x].style.maxHeight = maxImgSize[1]+'px';
      }
    }

  }




function colourThreads()
  {
  var ar = colourThreadsNames.split(',');
  var names = new Array();
  for(var i = 0; i < ar.length; i++)
    {
    var sub = ar[i].split('=');
    if(sub[0] && sub[1])
      names[unescape(sub[0])] = sub[1];
    }

  var elist = dom.class('text');
  for(var i = n = 0; i < elist.length; i++)
    {
    var a = elist[i].parentNode.getElementsByTagName('a')[0];
    var name = a.firstChild.data;
    if(names[name])
      {
      if(colourThreadsVar == 1)
        elist[i].style.backgroundColor = names[name];
      else if(colourThreadsVar == 2)
        a.parentNode.parentNode.style.backgroundColor = names[name];

      // Quotes:
      var quotes = elist[i].getElementsByClassName('quote_author');
      for(var x = 0; x < quotes.length; x++)
        {
         // Extract author's name
        var author = quotes[x].firstChild.data.split(' hat folgendes geschrieben:').shift();
        if(names[author])
          {
          if(colourThreadsVar == 1)
            {
            quotes[x].style.backgroundColor = names[author];
            quotes[x].parentNode.nextSibling.getElementsByClassName('quote_message')[0].style.backgroundColor = names[author];
            quotes[x].parentNode.parentNode.parentNode.style.border = '1px solid black';
            quotes[x].parentNode.parentNode.parentNode.style.borderLeft = '0px';
            }
          else if(colourThreadsVar == 2)
            {
            quotes[x].style.backgroundColor = names[author];
            quotes[x].parentNode.nextSibling.getElementsByClassName('quote_message')[0].style.border = names[author] + ' 3px solid';
            }
          }
        }

      }
    else
      {
      // Search next Colour that is not in list
      while(in_array(names,colours[n]))
        n++;

      names[name] = colours[n];
      if(colourThreadsVar == 1)
        elist[i].style.backgroundColor = names[name];
      else if(colourThreadsVar == 2)
        a.parentNode.parentNode.style.backgroundColor = names[name];

      // Quotes:
      var quotes = elist[i].getElementsByClassName('quote_author');
      for(var x = 0; x < quotes.length; x++)
        {
         // Extract author's name
        var author = quotes[x].firstChild.data.split(' hat folgendes geschrieben:').shift();
        if(names[author])
          {
          if(colourThreadsVar == 1)
            {
            quotes[x].style.backgroundColor = names[author];
            quotes[x].parentNode.nextSibling.getElementsByClassName('quote_message')[0].style.backgroundColor = names[author];
            quotes[x].parentNode.parentNode.parentNode.style.border = '1px solid black';
            quotes[x].parentNode.parentNode.parentNode.style.borderLeft = '0px';
            }
          else if(colourThreadsVar == 2)
            {
            quotes[x].style.backgroundColor = names[author];
            quotes[x].parentNode.nextSibling.getElementsByClassName('quote_message')[0].style.border = names[author] + ' 3px solid';
            }
          }
        }

      n++;
      }
    }
  var saveThing = new Array();
  for(p in names)
    {
    void saveThing.push(escape(p) + '=' + names[p]);
    }
  GM_setValue('colourThreadsNames',saveThing.join(','));
  }


function replaceSmilies()
  {
  if(!replaceSmiliesOn)
    return true;
  var elist = dom.class('text');
  for(var i = 0; i < elist.length; i++)
    {
    for(var key in smilies)
      {
      if(smilies[key][0] == 'img')
        {
        elist[i].innerHTML = elist[i].innerHTML.split(key).join( '<img title="'+key+'" alt="'+key+'" src="' +smilies[key][1] + '" />' );
        }
      }
    }
  }



function markAllRead()
  {
  if(mark_all_read_active)
    {

    // Black Screen
    var div = dom.n('div');
    div.style.position = 'fixed';
    div.style.top = '0px';
    div.style.bottom = '0px';
    div.style.left = '0px';
    div.style.right = '0px';
    div.style.backgroundColor = 'black';
    div.style.color = '#00ff00';
    div.style.opacity = '0.8';
    div.id = 'search_layer';
    div.innerHTML = '<h1>In process . . . . </h1>';

    dom.id('ds_body').appendChild(div);

    var links = GM_getValue('mark_all_read_links').split(',');

    // Redirect
    if(links[0])
      {

      var next_link = links.shift();

      GM_setValue('mark_all_read_links',links.join(','));

      document.location.href = url.split('?')[0]+'?screen=view_forum&action=mark_read&forum_id='+next_link;
      }
    else
      {
      GM_setValue('mark_all_read_active',false);
      GM_setValue('mark_all_read_links','');
      dom.id('search_layer').style.display = 'none';
      alert('Fertig!');
      }
    }
  else
    {
    var links = new Array();
    var elist = dom.id('ds_body').getElementsByTagName('div')[0].getElementsByTagName('a');
    for(var i = 0; i < elist.length; i++)
      {
      if(elist[i].getElementsByTagName('img')[0])
        {
        var id = elist[i].href.split('=').pop();
        void links.push(id);
        }
      }
    var next_link = links.shift();
    GM_setValue('mark_all_read_active',true);
    GM_setValue('mark_all_read_links',links.join(','));
    document.location.href = 'forum.php?screen=view_forum&action=mark_read&forum_id='+next_link;
    }
  }

function searchTitles(key)
  {

  // Black Screen
  var div = dom.n('div');
  div.style.position = 'fixed';
  div.style.top = '0px';
  div.style.bottom = '0px';
  div.style.left = '0px';
  div.style.right = '0px';
  div.style.backgroundColor = 'black';
  div.style.color = '#00ff00';
  div.style.opacity = '0.8';
  div.id = 'search_layer';
  div.innerHTML = '<h1>Suchen . . . .</h1>';

  dom.id('ds_body').appendChild(div);

  var baseURL = GM_getValue('search_baseURL');

  if(key)
    GM_setValue('search_string',key.toLowerCase())

  if(search_active)
    {
    var ids = GM_getValue('search_ids').split(',');
    var string = GM_getValue('search_string');

    var elist = dom.id('ds_body').getElementsByTagName('table')[2].getElementsByTagName('tr');
    for(var i = 1; i < elist.length; i++)
      {
      if(elist[i].getElementsByTagName('a')[0])
        {
        var title = elist[i].getElementsByTagName('a')[0].firstChild.data.toLowerCase();
        log(title);
        if(title.indexOf(string) != -1)
          {
          var id = elist[i].getElementsByTagName('a')[0].href.split('=')[elist[i].getElementsByTagName('a')[0].href.split('=').length - 1];
          var tmp = GM_getValue('search_result')+elist[i].getElementsByTagName('a')[0].firstChild.data+'?:?'+id+'?;?';
          GM_setValue('search_result',tmp);
          }
        }
      }

    // Redirect
    if(ids[0])
      {
      var next_id = ids.shift();
      GM_setValue('search_ids',ids.join(','));
      document.location.href = baseURL+next_id;
      }
    else
      {
      GM_setValue('search_active',false);

      var results = GM_getValue('search_result');
      GM_setValue('search_result','');
      results = results.split('?;?');


      // Show results
      dom.class('forum selected')[0].className = 'forum ';  // Unselect current forum in menu
      dom.tag('h1')[0].innerHTML = 'Ergebnis f'+unescape('%FC')+'r die Suche nach: '+string;
      dom.tag('h1')[0].nextSibling.innerHTML = '';

      // Delete old Threads
      var table = dom.id('ds_body').getElementsByTagName('table')[2].getElementsByTagName('tbody')[0];
      var elist = table.getElementsByTagName('tr');
      var tmp_url = '';
      for(var i = 1; i < elist.length; i++)
        {
        if(elist[i].getElementsByTagName('a')[0])
          {
          tmp_url = elist[i].getElementsByTagName('a')[0].href;
          table.removeChild(elist[i]);
          i--;
          }
        }

      // Create Base URL
      // tmp_url = http://de33.die-staemme.de/forum.php?screen=view_thread&thread_id&thread_id=27847
      var baseURL_Thread = tmp_url.split('=');
      void baseURL_Thread.pop();
      baseURL_Thread = baseURL_Thread.join('=');
      baseURL_Thread += '=';

      // Create threads
      for(var i = 0; i < results.length; i++)
        {
        var current = results[i].split('?:?');
        if(!current[1])
          break;
        var tr = dom.n('tr');
        var td = dom.n('td');

        var img = new Image();
        img.src = 'graphic/forum/thread_unread.png';
        img.alt = 'Suchergebnis'

        var a = dom.n('a');
        a.href = baseURL_Thread+current[1];
        var title = str_ireplace(string, '<span style="font-weight:bolder;">'+string.fontcolor('#FF0000')+'</span>', current[0]);

        a.innerHTML = title;

        dom.appendChilds(td,img,dom.text(' '),a);
        tr.appendChild(td);
        table.appendChild(tr);
        }
      dom.id('search_layer').style.display = 'none';
      }
    }
  else
    {
    var ids = new Array();
    var elist = dom.id('ds_body').getElementsByTagName('div')[0].getElementsByTagName('a');
    for(var i = 0; i < elist.length; i++)
      {
      // elist[i].href = forum.php?screen=view_forum&forum_id=13224
      void ids.push(parseInt(elist[i].href.split('=')[elist[i].href.split('=').length - 1]));
      }
    var next_id = ids.shift();
    GM_setValue('search_active',true);
    GM_setValue('search_ids',ids.join(','));
    document.location.href = baseURL+next_id;
    }
  }


function bar()
    {
    var div = dom.n('div');
    div.setAttribute('id','adIntBar');
    div.style.backgroundColor = 'rgb(243,237,223)';
    div.style.border = 'rgb(128,64,0) 2px solid';
    div.style.marginTop = '15px';
    div.style.padding = '5px';

    var input = dom.n('input');
    input.type = 'text';
    input.id = 'search_input_key';
    input.value = GM_getValue('search_string');
    input.style.color = 'silver';
    dom.addEvent(input,'click',function() { this.style.color = 'black'; } );
    dom.addEvent(input,'keyup',function(event) { if(event.keyCode == 13) searchTitles(document.getElementById('search_input_key').value); } );

    var button = dom.n('input');
    button.type = 'button';
    button.value = 'Titel durchsuchen';
    dom.addEvent(button,'click',function() {searchTitles(document.getElementById('search_input_key').value); });

    div.appendChild(input);
    div.appendChild(dom.text(' '));
    div.appendChild(button);

    var delimiter = dom.n('span');
    delimiter.setAttribute('style','margin-left:5px; margin-right:5px; width:1px; border:1px #804000 solid; ')
    div.appendChild(delimiter);

    var a = dom.n('a');
    a.setAttribute('href','#');
    dom.addEvent(a,'click',function(){ if(confirm('Wirklich ganzes Forum als gelesen markieren?')) markAllRead('first'); });
    a.appendChild(dom.text('Ganzes Forum als gelesen markieren'));

    div.appendChild(a);

    var delimiter = dom.n('span');
    delimiter.setAttribute('style','margin-left:5px; margin-right:5px; width:1px; border:1px #804000 solid; ')
    div.appendChild(delimiter);

    var a = dom.n('a');
    a.setAttribute('href','#');
    dom.addEvent(a,'click',function(){ menu_extras(); });
    a.setAttribute('id','link_menu_extras');
    a.appendChild(dom.text('Extras'));

    div.appendChild(a);


    return dom.id('ds_body').appendChild(div);
    }

function log(string)
  {
  dom.id('search_layer').innerHTML = dom.id('search_layer').innerHTML + randomStr(20,200) + string + randomStr(10,300);
  }


function rand(max)
{
return Math.ceil(Math.random() * 1000) % max + 1;
}
function randomStr(min,max,chars)
  {
  if(!chars)
    {
    chars = " 01"; // Zeichen die im String vorkommen dÃ¼rfen
    }
  stringlength = rand(max);
  i = 0;
  result = "";
  while(i < stringlength || i < min)
    {
    result = result + chars[rand(chars.length-1)];
    i++;
    }
  return result;
  }

function html()
  {
  this.n = function(type) // Returns a new element of the type [type]
    {
    return document.createElement(type);
    }

  this.text = function(c) // Returns a new textnode with the content [c]
    {
    return document.createTextNode(c);
    }

  this.img = function(c) // Returns a new textnode with the content [c]
    {
    if(c)
      {
      var img = new Image();
      img.src = c;
      return img;
      }
    return new Image();
    }

  // Search functions

  this.id = function(type)  // Returns the element with the id [type]
    {
    return document.getElementById(type);
    }

  this.tag = function(type) // Returns the list ob elements with the tag given in [type]
    {
    return document.getElementsByTagName(type);
    }

  this.name = function(type) // Returns the list ob elements with the tag name given in [type]
    {
    return document.getElementsByName(type);
    }

  this.class = function(type) // Returns the list ob elements with the class given in [type]
    {
    return document.getElementsByClassName(type);
    }

  this.findByAttr = function(obj,attr,value) // Returns a list ob elements that have an attribute [attr] with the value [value]
    {
    var len = obj.getElementsByTagName('*').length;
    var list = new Object();
    var  a = 0;
    for(var i = 0; i < len; i++)
      {
      if(obj.getElementsByTagName('*')[i][attr] == value)
        {
        list[a] = obj.getElementsByTagName('*')[i];
        a++;
        }
      }
    list['length'] = a;
    return list;
    }

  this.findByInner = function(obj,value) // Returns a list ob elements that contain the value [value]
    {
    var len = obj.getElementsByTagName('*').length;
    var list = new Object();
    var  a = 0;
    for(var i = 0; i < len; i++)
      {
      if(obj.getElementsByTagName('*')[i].firstChild)
        {
        if(obj.getElementsByTagName('*')[i].firstChild.data)
          {
          if(obj.getElementsByTagName('*')[i].firstChild.data.indexOf(value) != -1)
            {
            list[a] = obj.getElementsByTagName('*')[i];
            a++;
            }
          }
        }
      }
    list['length'] = a;
    return list;
    }

  this.appendChilds = function(obj)
    {
    for(var i = 1; i < arguments.length; i++)
      arguments[0].appendChild(arguments[i]);
    }

  this.removeChilds = function(obj)
    {
    while(obj.firstChild)
      {
      obj.removeChild(obj.firstChild);
      }
    }

  this.dumpObj = function(e,html,count)
    {
    if(!count)
      count = 0;
    var spaces = '  ';
    for(var i = 0; i < count; i++)
      spaces += '  ';
    if(html)
      n = '<br />\n';
    else
      n = '\n';
    var o = '( '+typeof(e)+' )'+n;
    for(var p in e)
      o+= spaces+p+' = '+'( '+typeof(e[p])+' ) '+(typeof(e[p]) == 'object'?(this.dumpObj(e[p],html,(count+2))):e[p])+n;
    return o;
    }



  // Gets the element (target) of a DOM Mouse Event Object
  // Returns false if there's no element
  this.mouseEventTarget = function(e)
    {
    if(e.target) // Mozilla, Opera, Safari
      return e.target;
    else if (e.srcElement) // IE
      return e.srcElement;
    else // No Target
      return false;
    }



  // Flexible Javascript Events by John Resig (ejohn.org)
  // http://ejohn.org/projects/flexible-javascript-events/
  this.addEvent = function( obj, type, fn )
    {
    if(obj.attachEvent)
      {
      obj['e'+type+fn] = fn;
      obj[type+fn] = function(){obj['e'+type+fn](window.event);}
      obj.attachEvent( 'on'+type, obj[type+fn] );
      }
    else
      obj.addEventListener( type, fn, false );
    }

  this.removeEvent = function( obj, type, fn )
    {
    if(obj.detachEvent)
      {
      obj.detachEvent( 'on'+type, obj[type+fn] );
      obj[type+fn] = null;
      }
    else
      obj.removeEventListener( type, fn, false );
    }

  return true;
  }

function in_array(obj,elem)
  {
  for(var attr in obj)
    {
    if(obj[attr] == elem)
      return true;
    }
  return false;
  }


function str_ireplace ( search, replace, subject ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Martijn Wieringa
    // +      input by: penutbutterjelly
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Jack
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Onno Marsman
    // *     example 1: str_ireplace('l', 'l', 'HeLLo');
    // *     returns 1: 'Hello'

    var i, k = '';
    var searchl = 0;

    search += '';
    searchl = search.length;
    if (!(replace instanceof Array)) {
        replace = new Array(replace);
        if (search instanceof Array) {
            // If search is an array and replace is a string,
            // then this replacement string is used for every value of search
            while (searchl > replace.length) {
                replace[replace.length] = replace[0];
            }
        }
    }

    if (!(search instanceof Array)) {
        search = new Array(search);
    }
    while (search.length>replace.length) {
        // If replace has fewer values than search,
        // then an empty string is used for the rest of replacement values
        replace[replace.length] = '';
    }

    if (subject instanceof Array) {
        // If subject is an array, then the search and replace is performed
        // with every entry of subject , and the return value is an array as well.
        for (k in subject) {
            subject[k] = str_ireplace(search, replace, subject[k]);
        }
        return subject;
    }

    searchl = search.length;
    for (i = 0; i < searchl; i++) {
        reg = new RegExp(search[i], 'gi');
        subject = subject.replace(reg, replace[i]);
    }

    return subject;
}