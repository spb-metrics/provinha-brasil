/*
 +-------------------------------------------------------------------+
 |                   H T M L - G R A P H S   (v3.1)                  |
 |                                                                   |
 | Copyright Gerd Tentler                www.gerd-tentler.de/tools   |
 | Created: Sep. 17, 2002                Last modified: May 24, 2005 |
 +-------------------------------------------------------------------+
 | This program may be used and hosted free of charge by anyone for  |
 | personal purpose as long as this copyright notice remains intact. |
 |                                                                   |
 | Obtain permission before selling the code for this program or     |
 | hosting this software on a commercial website or redistributing   |
 | this software over the Internet or in any other medium. In all    |
 | cases copyright must remain intact.                               |
 +-------------------------------------------------------------------+

======================================================================================================
 Example:

   graph = new BAR_GRAPH("hBar");
   graph.values = new Array(234, 125, 289, 147, 190);
   document.write(graph.create());

 Returns HTML code
------------------------------------------------------------------------------------------------------
 This script was tested with the following systems and browsers:

 - Windows XP: IE 6, NN 7, Opera 7, Firefox 1
 - Mac OS X:   IE 5, Safari 1

 If you use another browser or system, this script may not work for you - sorry.
======================================================================================================
*/
  var graphstyle_nr = 1;

  function BAR_GRAPH(type) {
//----------------------------------------------------------------------------------------------------
// Configuration
//----------------------------------------------------------------------------------------------------
    this.type = 'hBar';                       // graph type: "hBar", "vBar", "pBar", or "fader"
    if(type) this.type = type;
    this.values;                              // graph data: string with comma-separated values or array

    this.graphBGColor = '';                   // graph background color: string
    this.graphBorder = '';                    // graph border: string (CSS specification; doesn't work with NN4)
    this.graphPadding = 0;                    // graph padding: integer (pixels)

    this.labels;                              // label names: string with comma-separated values or array
    this.labelColor = 'black';                // label font color: string
    this.labelBGColor = '#C0E0FF';            // label background color: string
    this.labelBorder = '2px groove white';    // label border: string (CSS specification)
    this.labelFont = 'Arial, Helvetica';      // label font family: string (CSS specification)
    this.labelSize = 12;                      // label font size: integer (pixels)
    this.labelSpace = 0;                      // additional space between labels (pixels)

    this.barWidth = 20;                       // bar width: integer (pixels)
    this.barLength = 1.0;                     // bar length ratio: float (from 0.1 to 2.9)
    this.barColor;                            // bar color OR bar image: string with comma-separated values or array
    this.barBGColor;                          // bar background color: string
    this.barBorder = '2px outset white';      // bar border: string (CSS specification)
    this.barLevelColor;                       // bar level color: array (bLevel, bColor); draw bars >= bLevel with bColor

    this.showValues = 0;                      // show values: 0 = % only, 1 = abs. and %, 2 = abs. only, 3 = none

    this.absValuesColor;                      // abs. values font color: string (if not set, same color like labels)
    this.absValuesBGColor;                    // abs. values background color: string (if not set, same color like labels)
    this.absValuesBorder;                     // abs. values border: string (CSS specification; doesn't work with NN4; if not set, same border like labels)
    this.absValuesFont = 'Arial, Helvetica';  // abs. values font family: string (CSS specification)
    this.absValuesSize = 12;                  // abs. values font size: integer (pixels)
    this.absValuesPrefix = '';                // abs. values prefix: string (e.g. currency)

    this.percValuesColor = 'black';           // perc. values font color: string
    this.percValuesFont = 'Arial, Helvetica'; // perc. values font family: string (CSS specification)
    this.percValuesSize = 12;                 // perc. values font size: integer (pixels)
    this.percValuesDecimals = 0;              // perc. values number of decimals: integer

    this.charts = 1;                          // number of charts: integer

    // hBar/vBar only:
    this.legend;                              // legend items: string with comma-separated values or array
    this.legendColor = 'black';               // legend font color: string
    this.legendBGColor = '#F0F0F0';           // legend background color: string
    this.legendBorder = '2px groove white';   // legend border: string (CSS specification)
    this.legendFont = 'Arial, Helvetica';     // legend font family: string (CSS specification)
    this.legendSize = 12;                     // legend font size: integer (pixels)

    // debug mode: false = off, true = on; just shows some extra information
    this.debug = false;

    // default bar colors; only used if barColor isn't set
    this.colors = new Array('#0000FF', '#FF0000', '#00E000', '#A0A0FF', '#FFA0A0', '#00A000');

    // error messages
    this.err_type = 'ERROR: Type must be "hBar", "vBar", "pBar", or "fader"';

    // CSS class names (don't change)
    if(!graphstyle_nr) graphstyle_nr = 1;
    this.clsGRAPH = 'clsGRAPH' + graphstyle_nr;
    this.clsBAR = 'clsBAR' + graphstyle_nr;
    this.clsBARBG = 'clsBARBG' + graphstyle_nr;
    this.clsLABEL = 'clsLABEL' + graphstyle_nr;
    this.clsLABELBG = 'clsLABELBG' + graphstyle_nr;
    this.clsLEGEND = 'clsLEGEND' + graphstyle_nr;
    this.clsLEGENDBG = 'clsLEGENDBG' + graphstyle_nr;
    this.clsABSVALUES = 'clsABSVALUES' + graphstyle_nr;
    this.clsPERCVALUES = 'clsPERCVALUES' + graphstyle_nr;
    graphstyle_nr++;

//----------------------------------------------------------------------------------------------------
// Functions
//----------------------------------------------------------------------------------------------------
    this.set_style = function() {
      var style = '<style> .' + this.clsGRAPH + ' { ';
      if(this.graphBGColor) style += 'background-color: ' + this.graphBGColor + '; ';
      if(this.graphBorder) style += 'border: ' + this.graphBorder + '; ';
      style += '} .' + this.clsBAR + ' { ';
      if(this.barBorder) style += 'border: ' + this.barBorder + '; ';
      style += '} .' + this.clsBARBG + ' { ';
      if(this.barBGColor) style += 'background-color: ' + this.barBGColor + '; ';
      style += '} .' + this.clsLABEL + ' { ';
      if(this.labelColor) style += 'color: ' + this.labelColor + '; ';
      if(this.labelBGColor) style += 'background-color: ' + this.labelBGColor + '; ';
      if(this.labelBorder) style += 'border: ' + this.labelBorder + '; ';
      if(this.labelFont) style += 'font-family: ' + this.labelFont + '; ';
      if(this.labelSize) style += 'font-size: ' + this.labelSize + 'px; ';
      style += '} .' + this.clsLABELBG + ' { ';
      if(this.labelBGColor) style += 'background-color: ' + this.labelBGColor + '; ';
      style += '} .' + this.clsLEGEND + ' { ';
      if(this.legendColor) style += 'color: ' + this.legendColor + '; ';
      if(this.legendFont) style += 'font-family: ' + this.legendFont + '; ';
      if(this.legendSize) style += 'font-size: ' + this.legendSize + 'px; ';
      style += '} .' + this.clsLEGENDBG + ' { ';
      if(this.legendBGColor) style += 'background-color: ' + this.legendBGColor + '; ';
      if(this.legendBorder) style += 'border: ' + this.legendBorder + '; ';
      style += '} .' + this.clsABSVALUES + ' { ';
      if(this.absValuesColor) style += 'color: ' + this.absValuesColor + '; ';
      if(this.absValuesBGColor) style += 'background-color: ' + this.absValuesBGColor + '; ';
      if(this.absValuesBorder) style += 'border: ' + this.absValuesBorder + '; ';
      if(this.absValuesFont) style += 'font-family: ' + this.absValuesFont + '; ';
      if(this.absValuesSize) style += 'font-size: ' + this.absValuesSize + 'px; ';
      style += '} .' + this.clsPERCVALUES + ' { ';
      if(this.percValuesColor) style += 'color: ' + this.percValuesColor + '; ';
      if(this.percValuesFont) style += 'font-family: ' + this.percValuesFont + '; ';
      if(this.percValuesSize) style += 'font-size: ' + this.percValuesSize + 'px; ';
      style += '} </style>';
      return style;
      
    }

    this.level_color = function(value, color) {
      if(this.barLevelColor) {
        if((this.barLevelColor[0] > 0 && value >= this.barLevelColor[0]) ||
           (this.barLevelColor[0] < 0 && value <= this.barLevelColor[0])) {
          color = this.barLevelColor[1];
        }
      }
      return color;
    }

    this.draw_bar = function(width, height, color) {
      var bg = (color.search(/\.(jpg|jpeg|jpe|gif|png)$/i) != -1) ? 'background' : 'bgcolor';
      var bar = '<table border=0 cellspacing=0 cellpadding=0><tr>';
      bar += '<td class="' + this.clsBAR + '" ' + bg + '=' + color + '>';
      bar += '<table border=0 cellspacing=0 cellpadding=0><tr>';
      bar += '<td width=' + width + ' height=' + height + '></td>';
      bar += '</tr></table>';
      bar += '</td></tr></table>';
      return bar;
    }

    this.set_fader = function(width, height, x, color) {
      var btn = '<table border=0 cellspacing=0 cellpadding=0><tr>';
      x -= Math.round(width / 2);
      if(x > 0) btn += '<td width=' + x + '></td>';
      btn += '<td>' + this.draw_bar(width, height, color) + '</td>';
      btn += '</tr></table>';
      return btn;
    }

    this.format_value = function(val, dec) {
      if(dec) {
        if(val < 0) {
          var neg = true;
          val *= -1;
        }
        else var neg = false;
        var v = (Math.round(val * Math.pow(10, dec))).toString();
        if(v.length <= dec) for(var i = 0; i < dec - v.length + 1; i++) v = '0' + v;
        v = v.substr(0, v.length - dec) + '.' + v.substr(v.length - dec);
        if(v.substr(0, 1) == '.') v = '0' + v;
        if(neg) v = '-' + v;
      }
      else v = Math.round(val);
      return v;
    }

    this.show_value = function(val, max_dec, sum, align) {
      val = max_dec ? this.format_value(val, max_dec) : val;
      if(sum) sum = max_dec ? this.format_value(sum, max_dec) : sum;
      value = '<td class="' + this.clsABSVALUES + '"';
      if(align) value += ' align=' + align;
      value += ' nowrap>';
      value += '&nbsp;' + this.absValuesPrefix + val;
      if(sum) value += ' / ' + this.absValuesPrefix + sum;
      value += '&nbsp;</td>';
      return value;
    }

    this.build_legend = function(barColors) {
      var legend = '<table border=0 cellspacing=0 cellpadding=0><tr>';
      legend += '<td class="' + this.clsLEGENDBG + '">';
      legend += '<table border=0 cellspacing=4 cellpadding=0>';
      var l = (typeof(this.legend) == 'string') ? this.legend.split(',') : this.legend;

      for(i = 0; i < barColors.length; i++) {
        legend += '<tr>';
        legend += '<td>' + this.draw_bar(this.barWidth, this.barWidth, barColors[i]) + '</td>';
        legend += '<td class="' + this.clsLEGEND + '" nowrap>' + l[i] + '</td>';
        legend += '</tr>';
      }
      legend += '</table></td></tr></table>';
      return legend;
    }

    this.create = function() {
      this.type = this.type.toLowerCase();
      var d = (typeof(this.values) == 'string') ? this.values.split(',') : this.values;
      if(this.labels) var r = (typeof(this.labels) == 'string') ? this.labels.split(',') : this.labels;
      else var r = new Array();
      var label = graph = bColor = '';
      var percent = rowspan = colspan = 0;
      if(this.barColor) var drf = (typeof(this.barColor) == 'string') ? this.barColor.split(',') : this.barColor;
      else var drf = new Array();
      var drw, val = new Array();
      var bc = new Array();
      if(this.barLength < 0.1) this.barLength = 0.1;
      else if(this.barLength > 2.9) this.barLength = 2.9;
      var bars = (d.length > r.length) ? d.length : r.length;

      if(!this.absValuesColor) this.absValuesColor = this.labelColor;
      if(!this.absValuesBGColor) this.absValuesBGColor = this.labelBGColor;
      if(!this.absValuesBorder) this.absValuesBorder = this.labelBorder;

      if(this.type == 'pbar' || this.type == 'fader') {
        if(!this.barBGColor) this.barBGColor = this.labelBGColor;
        if(this.labelBGColor == this.barBGColor) {
          this.labelBGColor = '';
          this.labelBorder = '';
        }
      }

      graph += '<table border=0 cellspacing=0 cellpadding=' + this.graphPadding + '><tr>';
      graph += '<td class="' + this.clsGRAPH + '">';

      if(this.legend && this.type != 'pbar' && this.type != 'fader')
        graph += '<table border=0 cellspacing=0 cellpadding=0><tr valign=top><td>';

      if(this.charts > 1) {
        divide = Math.ceil(bars / this.charts);
        graph += '<table border=0 cellspacing=0 cellpadding=6><tr valign=top><td>';
      }
      else divide = 0;

      var sum = max = max_neg = max_dec = ccnt = lcnt = chart = 0;
      val[chart] = new Array();

      for(var i = 0; i < bars; i++) {
        if(divide && i && !(i % divide)) {
          lcnt = 0;
          chart++;
          val[chart] = new Array();
        }
        if(typeof(d[i]) == 'string') drw = d[i].split(';');
        else {
          drw = new Array();
          drw[0] = d[i];
        }
        val[chart][lcnt] = new Array();

        for(var j = v = 0; j < drw.length; j++) {
          val[chart][lcnt][j] = v = drw[j] ? parseFloat(drw[j]) : 0;

          if(v > max) max = v;
          else if(v < max_neg) max_neg = v;

          if(v < 0) v *= -1;
          sum += v;

          v = v.toString();
          if(v.indexOf('.') != -1) {
            v = v.substr(v.indexOf('.') + 1);
            dec = v.length;
            if(dec > max_dec) max_dec = dec;
          }

          if(!bc[j]) {
            if(ccnt >= this.colors.length) ccnt = 0;
            bc[j] = (!drf[j] || drf[j].length < 3) ? this.colors[ccnt++] : drf[j];
          }
        }
        lcnt++;
      }

      var border = parseInt(this.barBorder);
      var mPerc = sum ? Math.round(max * 100 / sum) : 0;
      if(this.type == 'pbar' || this.type == 'fader') var mul = 2;
      else var mul = mPerc ? 100 / mPerc : 1;
      mul *= this.barLength;

      if(this.showValues < 2) {
        if(this.type == 'hbar')
          valSpace = (this.percValuesDecimals * (this.percValuesSize / 1.7)) + (this.percValuesSize * 2.2);
        else valSpace = this.percValuesSize * 1.2;
      }
      else valSpace = this.percValuesSize;
      var spacer = maxSize = Math.round(mPerc * mul + valSpace + border * 2);

      if(max_neg) {
        var mPerc_neg = sum ? Math.round(-max_neg * 100 / sum) : 0;
        var spacer_neg = Math.round(mPerc_neg * mul + valSpace + border * 2);
        maxSize += spacer_neg;
      }

      for(chart = lcnt = 0; chart < val.length; chart++) {
        graph += '<table border=0 cellspacing=2 cellpadding=0>';

        if(this.type == 'hbar') {
          for(i = 0; i < val[chart].length; i++, lcnt++) {
            label = (lcnt < r.length) ? r[lcnt] : lcnt+1;
            rowspan = val[chart][i].length;
            graph += '<tr><td class="' + this.clsLABEL + '"' + ((rowspan > 1) ? ' rowspan=' + rowspan : '') + ' align=center>';
            graph += '&nbsp;' + label + '&nbsp;</td>';

            for(j = 0; j < val[chart][i].length; j++) {
              percent = sum ? val[chart][i][j] * 100 / sum : 0;
              bColor = this.level_color(val[chart][i][j], bc[j]);

              if(this.showValues == 1 || this.showValues == 2)
                graph += this.show_value(val[chart][i][j], max_dec, 0, 'right');

              graph += '<td class="' + this.clsBARBG + '" height=100% width=' + maxSize + '>';
              graph += '<table border=0 cellspacing=0 cellpadding=0 height=100%><tr>';

              if(percent < 0) {
                percent *= -1;
                graph += '<td class="' + this.clsLABELBG + '" height=' + this.barWidth + ' width=' + Math.round((mPerc_neg - percent) * mul + valSpace) + ' align=right nowrap>';
                if(this.showValues < 2) graph += '<span class="' + this.clsPERCVALUES + '">' + this.format_value(percent, this.percValuesDecimals) + '%</span>';
                graph += '&nbsp;</td><td class="' + this.clsLABELBG + '">';
                graph += this.draw_bar(Math.round(percent * mul), this.barWidth, bColor);
                graph += '</td><td width=' + spacer + '></td>';
              }
              else {
                if(max_neg) {
                  graph += '<td class="' + this.clsLABELBG + '" width=' + spacer_neg + '>';
                  graph += '<table border=0 cellspacing=0 cellpadding=0><tr><td></td></tr></table></td>';
                }
                if(percent) {
                  graph += '<td>';
                  graph += this.draw_bar(Math.round(percent * mul), this.barWidth, bColor);
                  graph += '</td>';
                }
                else graph += '<td height=' + (this.barWidth + (border * 2)) + '></td>';
                graph += '<td class="' + this.clsPERCVALUES + '" width=' + Math.round((mPerc - percent) * mul + valSpace) + ' nowrap>';
                if(this.showValues < 2) graph += '&nbsp;' + this.format_value(percent, this.percValuesDecimals) + '%';
                graph += '&nbsp;</td>';
              }
              graph += '</tr></table></td></tr>';
              if(j < val[chart][i].length - 1) graph += '<tr>';
            }
            if(this.labelSpace && i < val[chart].length-1) graph += '<tr><td colspan=3 height=' + this.labelSpace + '></td></tr>';
          }
        }
        else if(this.type == 'vbar') {
          graph += '<tr align=center valign=bottom>';
          for(i = 0; i < val[chart].length; i++) {

            for(j = 0; j < val[chart][i].length; j++) {
              percent = sum ? val[chart][i][j] * 100 / sum : 0;
              bColor = this.level_color(val[chart][i][j], bc[j]);

              graph += '<td class="' + this.clsBARBG + '">';
              graph += '<table border=0 cellspacing=0 cellpadding=0 width=100%><tr align=center>';

              if(percent < 0) {
                percent *= -1;
                graph += '<td height=' + spacer + '></td></tr><tr align=center valign=top><td class="' + this.clsLABELBG + '">';
                graph += this.draw_bar(this.barWidth, Math.round(percent * mul), bColor);
                graph += '</td></tr><tr align=center valign=top>';
                graph += '<td class="' + this.clsLABELBG + '" height=' + Math.round((mPerc_neg - percent) * mul + valSpace) + ' nowrap>';
                graph += (this.showValues < 2) ? '<span class="' + this.clsPERCVALUES + '">' + this.format_value(percent, this.percValuesDecimals) + '%</span>' : '&nbsp;';
                graph += '</td>';
              }
              else {
                graph += '<td class="' + this.clsPERCVALUES + '" valign=bottom height=' + Math.round((mPerc - percent) * mul + valSpace) + ' nowrap>';
                if(this.showValues < 2) graph += this.format_value(percent, this.percValuesDecimals) + '%';
                graph += '</td>';
                if(percent) {
                  graph += '</tr><tr align=center valign=bottom><td>';
                  graph += this.draw_bar(this.barWidth, Math.round(percent * mul), bColor);
                  graph += '</td>';
                }
                else graph += '</tr><tr><td width=' + (this.barWidth + (border * 2)) + '></td>';
                if(max_neg) {
                  graph += '</tr><tr><td class="' + this.clsLABELBG + '" height=' + spacer_neg + '>';
                  graph += '<table border=0 cellspacing=0 cellpadding=0><tr><td></td></tr></table></td>';
                }
              }
              graph += '</tr></table></td>';
            }
            if(this.labelSpace) graph += '<td width=' + this.labelSpace + '></td>';
          }
          if(this.showValues == 1 || this.showValues == 2) {
            graph += '</tr><tr align=center>';
            for(i = 0; i < val[chart].length; i++) {
              for(j = 0; j < val[chart][i].length; j++) {
                graph += this.show_value(val[chart][i][j], max_dec);
              }
              if(this.labelSpace) graph += '<td width=' + this.labelSpace + '></td>';
            }
          }
          graph += '</tr><tr align=center>';
          for(i = 0; i < val[chart].length; i++, lcnt++) {
            label = (lcnt < r.length) ? r[lcnt] : lcnt+1;
            colspan = val[chart][i].length;
            graph += '<td class="' + this.clsLABEL + '"' + ((colspan > 1) ? ' colspan=' + colspan : '') + '>';
            graph += '&nbsp;' + label + '&nbsp;</td>';
            if(this.labelSpace) graph += '<td width=' + this.labelSpace + '></td>';
          }
          graph += '</tr>';
        }
        else if(this.type == 'pbar' || this.type == 'fader') {
          for(i = 0; i < val[chart].length; i++, lcnt++) {
            label = (lcnt < r.length) ? r[lcnt] : '';
            graph += '<tr>';

            if(label) {
              graph += '<td class="' + this.clsLABEL + '" align=right>';
              graph += '&nbsp;' + label + '&nbsp;</td>';
            }
            sum = val[chart][i][1] ? val[chart][i][1] : 0;
            percent = sum ? val[chart][i][0] * 100 / sum : 0;

            if(this.showValues == 1 || this.showValues == 2)
              graph += this.show_value(val[chart][i][0], max_dec, sum, 'right');

            graph += '<td class="' + this.clsBARBG + '">';

            this.barColor = drf[i] ? drf[i] : this.colors[0];
            bColor = this.level_color(val[chart][i][0], this.barColor);
            graph += '<table border=0 cellspacing=0 cellpadding=0><tr><td>';
            if(this.type == 'fader') graph += this.set_fader(6, this.barWidth, Math.round(percent * mul), bColor);
            else graph += this.draw_bar(Math.round(percent * mul), this.barWidth, bColor);
            graph += '</td><td width=' + Math.round((100 - percent) * mul) + '></td>';
            graph += '</tr></table></td>';
            if(this.showValues < 2) graph += '<td class="' + this.clsPERCVALUES + '" nowrap>&nbsp;' + this.format_value(percent, this.percValuesDecimals) + '%</td>';
            graph += '</tr>';
            if(this.labelSpace && i < val[chart].length-1) graph += '<td colspan=3 height=' + this.labelSpace + '></td>';
          }
        }
        else graph += '<tr><td>' + this.err_type + '</td></tr>';

        graph += '</table>';

        if(chart < this.charts - 1 && val[chart+1].length) {
          graph += '</td>';
          if(this.type == 'vbar') graph += '</tr><tr valign=top>';
          graph += '<td>';
        }
      }

      if(this.charts > 1) graph += '</td></tr></table>';

      if(this.legend && this.type != 'pbar' && this.type != 'fader') {
        graph += '</td><td width=10>&nbsp;</td><td>';
        graph += this.build_legend(bc);
        graph += '</td></tr></table>';
      }

      if(this.debug) {
        graph += '<br>sum='+sum+' max='+max+' max_neg='+max_neg+' mPerc='+mPerc;
        graph += ' mPerc_neg='+mPerc_neg+' mul='+mul+' valSpace='+valSpace;
      }

      graph += '</td></tr></table>';
      graph += this.set_style();

      return graph;
    }
  }
