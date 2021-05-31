<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
<html>
<body>
<div class="row" style="height:500px;">
<div class="col-6">
<h4>Όλες οι παραγγελίες</h4>
<table id="ordTable" border="3px solid black">
<thead>
<tr bgcolor="#f0ad4e">
<th style="text-align:left">Κωδικός Παραγγελίας</th>
<th style="text-align:left">Επωνυμο</th>
<th style="text-align:left">Όνομα</th>
<th style="text-align:left">Αξία Παραγγελίας</th>
</tr>
</thead>
<tbody>
<xsl:for-each select="aboutOrders/allOrders/order">
<tr>
<td>
<xsl:value-of select="orderCode"/>
</td>
<td>
<xsl:value-of select="lastName"/>
</td>
<td>
<xsl:value-of select="firstName"/>
</td>
<td>
<xsl:value-of select="totalValue"/>
</td>
</tr>
</xsl:for-each>
</tbody>
</table>
</div>
<div class="col-6">
<h4>Top 5 προϊόντων με τις περισσοτερες πωλησεις</h4>
<table border="3px solid black">
<tr bgcolor="#f0ad4e">
<th style="text-align:left">Κωδικός Προϊόντος</th>
<th style="text-align:left">Όνομα Προϊόντος</th>
<th style="text-align:left">Συνολο Παραγγελιών</th>
</tr>
<xsl:for-each select="aboutOrders/popProducts/product">
<tr>
<td>
<xsl:value-of select="prodCode"/>
</td>
<td>
<xsl:value-of select="prodName"/>
</td>
<td>
<xsl:value-of select="totalSoldQuantity"/>
</td>
</tr>
</xsl:for-each>
</table>
</div>
</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>