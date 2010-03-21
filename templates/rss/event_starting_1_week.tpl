{*
 * Suomen Frisbeeliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhm║
 *
 * RSS message for event start warning
 * 
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 * *}
 <title>{translate id=rss_event_in_1_week}</title>
<description>{translate id=rss_event_in_1_week_text arguments=$item}</description>
<pubDate>{$item.rssDate}</pubDate>
<link>http://{$smarty.server.HTTP_HOST}{$url_base}event/{$event->id}</link>
<guid>1-week-to-event</guid>
