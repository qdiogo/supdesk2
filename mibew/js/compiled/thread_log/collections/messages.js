/*!
 * This file is a part of  Messenger.
 *
 * Copyright 2005-2021 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
!function(e,s){e.Collections.Messages=s.Collection.extend({model:e.Models.Message,updateMessages:function(e){for(var s=[],n=0;n<e.length;n++)e[n].message&&s.push(e[n]);s.length>0&&this.add(s)}})}(Mibew,Backbone);