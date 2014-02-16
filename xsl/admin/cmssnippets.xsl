<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:include href="tpl.default.xsl" />

	<xsl:template name="tabs">
		<ul class="tabs">
			<xsl:if test="/root/meta/controller">
				<xsl:call-template name="tab">
					<xsl:with-param name="href"      select="'cmssnippets'" />
					<xsl:with-param name="text"      select="'List cmssnippets'" />
				</xsl:call-template>

				<xsl:call-template name="tab">
					<xsl:with-param name="href"      select="'cmssnippets/cmssnippet'" />
					<xsl:with-param name="text"      select="'Add cmssnippet'" />
					<xsl:with-param name="action"    select="'cmssnippet'" />
					<xsl:with-param name="url_param" select="''" />
				</xsl:call-template>
			</xsl:if>
		</ul>
	</xsl:template>

	<xsl:template match="/">
		<xsl:if test="/root/content[../meta/action = 'index']">
			<xsl:call-template name="template">
				<xsl:with-param name="title" select="'Admin - Cmssnippets'" />
				<xsl:with-param name="h1"    select="'Cmssnippets'" />
			</xsl:call-template>
		</xsl:if>
		<xsl:if test="/root/content[../meta/action = 'cmssnippet']">
			<xsl:call-template name="template">
				<xsl:with-param name="title" select="'Admin - Cmssnippets'" />
				<xsl:with-param name="h1"    select="'Cmssnippets'" />
			</xsl:call-template>
		</xsl:if>
	</xsl:template>

	<!-- List cmssnippets -->
	<xsl:template match="content[../meta/action = 'index']">
		<table>
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Group</th>
					<th>Locale</th>
					<th>-</th>
				</tr>
			</thead>
			<tbody>
				<xsl:for-each select="cmssnippets/cmssnippet">
					<tr>
						<td><xsl:value-of select="@id" /></td>
						<td><xsl:value-of select="name" /></td>
						<td><xsl:value-of select="group" /></td>
						<td><xsl:value-of select="locale" /></td>
						<td>[<a href="/admin/cmssnippets/cmssnippet?id={@id}&amp;rm=1">Delete</a>] [<a href="/admin/cmssnippets/cmssnippet?id={@id}">Edit</a>]</td>
					</tr>
				</xsl:for-each>
			</tbody>
		</table>
	</xsl:template>

	<!-- Add or edit cmssnippet -->
	<xsl:template match="content[../meta/action = 'cmssnippet']">
		<form method="post" class="admin">
			<fieldset>
				<legend>
					<xsl:text>CMS Snippet</xsl:text>
					<xsl:if test="/root/meta/url_param/id"> #<xsl:value-of select="/root/meta/url_param/id" /></xsl:if>
				</legend>

				<xsl:call-template name="form_line">
					<xsl:with-param name="id"    select="'name'" />
					<xsl:with-param name="label" select="'Name:'" />
				</xsl:call-template>

				<xsl:call-template name="form_line">
					<xsl:with-param name="id"    select="'locale'" />
					<xsl:with-param name="label" select="'Locale:'" />
				</xsl:call-template>

				<xsl:call-template name="form_line">
					<xsl:with-param name="id"    select="'group'" />
					<xsl:with-param name="label" select="'Group:'" />
				</xsl:call-template>

				<xsl:call-template name="form_line">
					<xsl:with-param name="id"    select="'content'" />
					<xsl:with-param name="label" select="'Content:'" />
					<xsl:with-param name="type"  select="'textarea'" />
				</xsl:call-template>

				<div class="controls">
					<xsl:if test="/root/meta/url_params/id">
						<button class="longman negative" type="submit" name="action" value="rm">Delete</button>
					</xsl:if>
					<button class="longman positive" type="submit" name="action" value="save">Save</button>
				</div>
			</fieldset>
		</form>
	</xsl:template>

</xsl:stylesheet>