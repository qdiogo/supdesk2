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
 
 
 function preencher(){
	
 }
! function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates._logo = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != (o = null != e ? r(e, "page") : e) ? r(o, "mibewHost") : o, {
                name: "if",
                hash: {},
                fn: n.program(2, t, 0),
                inverse: n.program(4, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 5,
                        column: 12
                    },
                    end: {
                        line: 11,
                        column: 19
                    }
                }
            })) ? o : ""
        },
        2: function(n, e, l, a, t) {
            var o, r = n.lambda,
                s = n.escapeExpression,
                i = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "                <a onclick=\"window.open('" + s(r(null != (o = null != e ? i(e, "page") : e) ? i(o, "mibewHost") : o, e)) + '\');return false;" href="' + s(r(null != (o = null != e ? i(e, "page") : e) ? i(o, "mibewHost") : o, e)) + '">\n                    <img src="' + s(r(null != (o = null != (o = null != e ? i(e, "page") : e) ? i(o, "company") : o) ? i(o, "chatLogoURL") : o, e)) + '" alt=""/>\n                </a>\n'
        },
        4: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '                <img src="' + n.escapeExpression(n.lambda(null != (o = null != (o = null != e ? r(e, "page") : e) ? r(o, "company") : o) ? r(o, "chatLogoURL") : o, e)) + '" alt=""/>\n'
        },
        6: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != (o = null != e ? r(e, "page") : e) ? r(o, "mibewHost") : o, {
                name: "if",
                hash: {},
                fn: n.program(7, t, 0),
                inverse: n.program(9, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 13,
                        column: 12
                    },
                    end: {
                        line: 19,
                        column: 19
                    }
                }
            })) ? o : ""
        },
        7: function(n, e, l, a, t) {
            var o, r = n.lambda,
                s = n.escapeExpression,
                i = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "                <a onclick=\"window.open('" + s(r(null != (o = null != e ? i(e, "page") : e) ? i(o, "mibewHost") : o, e)) + '\');return false;" href="' + s(r(null != (o = null != e ? i(e, "page") : e) ? i(o, "mibewHost") : o, e)) + '">\n                    <img src="' + s(r(null != (o = null != e ? i(e, "page") : e) ? i(o, "stylePath") : o, e)) + '/images/default-logo.png" alt=""/>\n                </a>\n'
        },
        9: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '                <img src="' + n.escapeExpression(n.lambda(null != (o = null != e ? r(e, "page") : e) ? r(o, "stylePath") : o, e)) + '/images/default-logo.png" alt=""/>\n'
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<div id="logo-wrapper">\n    <div id="logo">\n' + (null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != (o = null != (o = null != e ? r(e, "page") : e) ? r(o, "company") : o) ? r(o, "chatLogoURL") : o, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.program(6, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 4,
                        column: 8
                    },
                    end: {
                        line: 20,
                        column: 15
                    }
                }
            })) ? o : "") + '        &nbsp;\n        <div id="page-title">' + n.escapeExpression(n.lambda(null != (o = null != e ? r(e, "page") : e) ? r(o, "title") : o, e)) + '</div>\n        <div class="clear">&nbsp;</div>\n    </div>\n</div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates.default_control = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return "<strong>" + n.escapeExpression((o = null != (o = r(l, "title") || (null != e ? r(e, "title") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "title",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 8
                    },
                    end: {
                        line: 1,
                        column: 17
                    }
                }
            }) : o)) + "</strong>"
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates.message = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = "function",
                u = n.escapeExpression,
                c = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "<span class='name-" + u((o = null != (o = c(l, "kindName") || (null != e ? c(e, "kindName") : e)) ? o : s, typeof o === i ? o.call(r, {
                name: "kindName",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 30
                    },
                    end: {
                        line: 2,
                        column: 42
                    }
                }
            }) : o)) + "'>" + u((o = null != (o = c(l, "name") || (null != e ? c(e, "name") : e)) ? o : s, typeof o === i ? o.call(r, {
                name: "name",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 44
                    },
                    end: {
                        line: 2,
                        column: 52
                    }
                }
            }) : o)) + "</span>: "
        },
        3: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression((o(l, "urlReplace") || e && o(e, "urlReplace") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, null != e ? o(e, "message") : e, {
                name: "urlReplace",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 60
                    },
                    end: {
                        line: 3,
                        column: 82
                    }
                }
            }))
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r, s = null != e ? e : n.nullContext || {},
                i = n.hooks.helperMissing,
                u = n.escapeExpression,
                c = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "<span>" + u((c(l, "formatTime") || e && c(e, "formatTime") || i).call(s, null != e ? c(e, "created") : e, {
                name: "formatTime",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 6
                    },
                    end: {
                        line: 1,
                        column: 28
                    }
                }
            })) + "</span>\n" + (null != (o = c(l, "if").call(s, null != e ? c(e, "name") : e, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 0
                    },
                    end: {
                        line: 2,
                        column: 68
                    }
                }
            })) ? o : "") + "\n<span class='message-" + u((r = null != (r = c(l, "kindName") || (null != e ? c(e, "kindName") : e)) ? r : i, "function" == typeof r ? r.call(s, {
                name: "kindName",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 21
                    },
                    end: {
                        line: 3,
                        column: 33
                    }
                }
            }) : r)) + "'>" + (null != (o = (c(l, "replace") || e && c(e, "replace") || i).call(s, "\\n", "<br/>", {
                name: "replace",
                hash: {},
                fn: n.program(3, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 35
                    },
                    end: {
                        line: 3,
                        column: 94
                    }
                }
            })) ? o : "") + "</span><br/>"
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/avatar"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<img src="' + n.escapeExpression((o = null != (o = r(l, "imageLink") || (null != e ? r(e, "imageLink") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "imageLink",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 27
                    },
                    end: {
                        line: 1,
                        column: 40
                    }
                }
            }) : o)) + '" border="0" alt="" />'
        },
        3: function(n, e, l, a, t) {
            return '<div class="default-avatar"></div>'
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? r(e, "imageLink") : e, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.program(3, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 1,
                        column: 111
                    }
                }
            })) ? o : ""
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/layout"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            return '        <div id="avatar-region"></div>\n'
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return (null != (o = n.invokePartial(s(a, "_logo"), e, {
                name: "_logo",
                data: t,
                helpers: l,
                partials: a,
                decorators: n.decorators
            })) ? o : "") + '\n<div id="chat-header">\n    <div class="background-center"><div class="background-left"><div class="background-right">\n        <div id="controls-region"></div>\n    </div></div></div>\n</div>\n\n<div id="chat">\n    <div class="background-left"><div class="background-right"><div class="background-shady-center"><div class="background-shady-left"><div class="background-shady-right">\n' + (null != (o = s(l, "unless").call(r, null != (o = null != e ? s(e, "user") : e) ? s(o, "isAgent") : o, {
                name: "unless",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 15,
                        column: 8
                    },
                    end: {
                        line: 17,
                        column: 19
                    }
                }
            })) ? o : "") + '        <div id="messages-region"></div>\n        <div id="status-region"></div>\n    </div></div></div></div></div>\n</div>\n\n<div id="message-form-region"></div>\n\n<div id="footer">' + n.escapeExpression((s(l, "l10n") || e && s(e, "l10n") || n.hooks.helperMissing).call(r, "Powered by:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 29,
                        column: 17
                    },
                    end: {
                        line: 29,
                        column: 39
                    }
                }
            })) + ' <a id="poweredby-link" href="http://supdesk.serveirc.com" title=" Messenger project" target="_blank">supdesk.serveirc.com</a></div>'
        },
        usePartial: !0,
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/message"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = "function",
                u = n.escapeExpression,
                c = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "<span class='name-" + u((o = null != (o = c(l, "kindName") || (null != e ? c(e, "kindName") : e)) ? o : s, typeof o === i ? o.call(r, {
                name: "kindName",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 30
                    },
                    end: {
                        line: 2,
                        column: 42
                    }
                }
            }) : o)) + "'>" + u((o = null != (o = c(l, "name") || (null != e ? c(e, "name") : e)) ? o : s, typeof o === i ? o.call(r, {
                name: "name",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 44
                    },
                    end: {
                        line: 2,
                        column: 52
                    }
                }
            }) : o)) + "</span>: "
        },
        3: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression((o(l, "urlReplace") || e && o(e, "urlReplace") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, null != e ? o(e, "message") : e, {
                name: "urlReplace",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 60
                    },
                    end: {
                        line: 3,
                        column: 82
                    }
                }
            }))
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r, s = null != e ? e : n.nullContext || {},
                i = n.hooks.helperMissing,
                u = n.escapeExpression,
                c = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "<span>" + u((c(l, "formatTime") || e && c(e, "formatTime") || i).call(s, null != e ? c(e, "created") : e, {
                name: "formatTime",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 6
                    },
                    end: {
                        line: 1,
                        column: 28
                    }
                }
            })) + "</span> \n" + (null != (o = c(l, "if").call(s, null != e ? c(e, "name") : e, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 0
                    },
                    end: {
                        line: 2,
                        column: 68
                    }
                }
            })) ? o : "") + "\n<span class='message-" + u((r = null != (r = c(l, "kindName") || (null != e ? c(e, "kindName") : e)) ? r : i, "function" == typeof r ? r.call(s, {
                name: "kindName",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 21
                    },
                    end: {
                        line: 3,
                        column: 33
                    }
                }
            }) : r)) + "'>" + (null != (o = (c(l, "replace") || e && c(e, "replace") || i).call(s, "\\n", "<br/>", {
                name: "replace",
                hash: {},
                fn: n.program(3, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 35
                    },
                    end: {
                        line: 3,
                        column: 94
                    }
                }
            })) ? o : "") + "</span><br/>"
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/message_form"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            return '    <div class="background-center"><div class="background-left"><div class="background-right">\n        <textarea id="message-input" class="message" tabindex="0" rows="4" cols="10"></textarea>\n    </div></div></div>\n'
        },
        3: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '    <div id="post-message">\n        <div id="predefined-wrapper">\n' + (null != (o = i(l, "if").call(r, null != (o = null != e ? i(e, "user") : e) ? i(o, "isAgent") : o, {
                name: "if",
                hash: {},
                fn: n.program(4, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 13,
                        column: 12
                    },
                    end: {
                        line: 20,
                        column: 19
                    }
                }
            })) ? o : "") + '        </div>\n        <a href="javascript:void(0)" id="send-message" title="' + n.escapeExpression((i(l, "l10n") || e && i(e, "l10n") || s).call(r, "Send message", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 22,
                        column: 62
                    },
                    end: {
                        line: 22,
                        column: 85
                    }
                }
            })) + '">' + (null != (o = (i(l, "l10n") || e && i(e, "l10n") || s).call(r, "Send ({0})", null != e ? i(e, "sendShortcut") : e, {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 22,
                        column: 87
                    },
                    end: {
                        line: 22,
                        column: 123
                    }
                }
            })) ? o : "") + "</a>\n    </div>\n"
        },
        4: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '                <select id="predefined" size="1" class="answer">\n                    <option>' + n.escapeExpression((s(l, "l10n") || e && s(e, "l10n") || n.hooks.helperMissing).call(r, "Select answer...", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 15,
                        column: 28
                    },
                    end: {
                        line: 15,
                        column: 55
                    }
                }
            })) + "</option>\n" + (null != (o = s(l, "each").call(r, null != e ? s(e, "predefinedAnswers") : e, {
                name: "each",
                hash: {},
                fn: n.program(5, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 16,
                        column: 16
                    },
                    end: {
                        line: 18,
                        column: 25
                    }
                }
            })) ? o : "") + "                </select>\n"
        },
        5: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return "                    <option>" + n.escapeExpression(n.lambda(null != e ? o(e, "short") : e, e)) + "</option>\n"
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '<div id="message">\n' + (null != (o = s(l, "if").call(r, null != (o = null != e ? s(e, "user") : e) ? s(o, "canPost") : o, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 0
                    },
                    end: {
                        line: 6,
                        column: 7
                    }
                }
            })) ? o : "") + '</div>\n\n<div id="send">\n' + (null != (o = s(l, "if").call(r, null != (o = null != e ? s(e, "user") : e) ? s(o, "canPost") : o, {
                name: "if",
                hash: {},
                fn: n.program(3, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 10,
                        column: 0
                    },
                    end: {
                        line: 24,
                        column: 7
                    }
                }
            })) ? o : "") + '</div>\n<div class="clear"></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["invitation/layout"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            return '<div id="invitation-messages-region"></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["leave_message/description"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '<div class="buttons">\n    <a href="javascript:Supdesk.Utils.closeChatPopup();" title="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Close", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 62
                    },
                    end: {
                        line: 2,
                        column: 78
                    }
                }
            })) + '">\n        <img class="tpl-image image-close-window" src="' + i(n.lambda(null != (o = null != e ? u(e, "page") : e) ? u(o, "stylePath") : o, e)) + '/images/free.gif" alt="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Close", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 96
                    },
                    end: {
                        line: 3,
                        column: 112
                    }
                }
            })) + '" />\n    </a>\n</div>\n<div class="info-message">' + (null != (o = (u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Sorry. None of the support team is available at the moment. <br/>Please leave a message and someone will get back to you shortly.", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 6,
                        column: 26
                    },
                    end: {
                        line: 6,
                        column: 168
                    }
                }
            })) ? o : "") + "</div>"
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["leave_message/form"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? r(e, "groupId") : e, {
                name: "if",
                hash: {},
                fn: n.program(2, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 5,
                        column: 22
                    },
                    end: {
                        line: 5,
                        column: 99
                    }
                }
            })) ? o : ""
        },
        2: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<input type="hidden" name="group" value="' + n.escapeExpression((o = null != (o = r(l, "groupId") || (null != e ? r(e, "groupId") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "groupId",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 5,
                        column: 78
                    },
                    end: {
                        line: 5,
                        column: 89
                    }
                }
            }) : o)) + '"/>'
        },
        4: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '        <tr>\n            <td class="text"><strong>' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Choose Department:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 20,
                        column: 37
                    },
                    end: {
                        line: 20,
                        column: 66
                    }
                }
            })) + '</strong></td>\n            <td>\n                <select name="group" style="min-width:200px;">\n' + (null != (o = u(l, "each").call(r, null != e ? u(e, "groups") : e, {
                name: "each",
                hash: {},
                fn: n.program(5, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 23,
                        column: 20
                    },
                    end: {
                        line: 25,
                        column: 29
                    }
                }
            })) ? o : "") + '                </select>\n            </td>\n        </tr>\n        <tr>\n            <td class="text"><strong>' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Department description:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 30,
                        column: 37
                    },
                    end: {
                        line: 30,
                        column: 71
                    }
                }
            })) + '</strong></td>\n            <td class="text" id="group-description">\n                ' + (null != (o = u(l, "each").call(r, null != e ? u(e, "groups") : e, {
                name: "each",
                hash: {},
                fn: n.program(8, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 32,
                        column: 16
                    },
                    end: {
                        line: 32,
                        column: 89
                    }
                }
            })) ? o : "") + "\n            </td>\n        </tr>\n"
        },
        5: function(n, e, l, a, t) {
            var o, r = n.lambda,
                s = n.escapeExpression,
                i = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '                        <option value="' + s(r(null != e ? i(e, "id") : e, e)) + '" ' + (null != (o = i(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? i(e, "selected") : e, {
                name: "if",
                hash: {},
                fn: n.program(6, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 24,
                        column: 52
                    },
                    end: {
                        line: 24,
                        column: 99
                    }
                }
            })) ? o : "") + ">" + s(r(null != e ? i(e, "name") : e, e)) + "</option>\n"
        },
        6: function(n, e, l, a, t) {
            return 'selected="selected"'
        },
        8: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? r(e, "selected") : e, {
                name: "if",
                hash: {},
                fn: n.program(9, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 32,
                        column: 32
                    },
                    end: {
                        line: 32,
                        column: 80
                    }
                }
            })) ? o : ""
        },
        9: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression(n.lambda(null != e ? o(e, "description") : e, e))
        },
        11: function(n, e, l, a, t) {
            return '        <tr>\n            <td><img id="captcha-img" src="captcha"/></td>\n            <td><input type="text" name="captcha" size="50" maxlength="15" value="" class="username"/></td>\n        </tr>\n'
        },
        13: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '        <tr>\n            <td colspan="2"><strong>' + (null != (o = (r(l, "l10n") || e && r(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, 'Please note that by leaving the message you\'re explicitly agree with the <a href="{0}" target="_blank">Privacy Policy</a>', null != e ? r(e, "privacyPolicyUrl") : e, {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 50,
                        column: 36
                    },
                    end: {
                        line: 50,
                        column: 191
                    }
                }
            })) ? o : "") + "</strong></td>\n        </tr>\n"
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r, s = n.lambda,
                i = n.escapeExpression,
                u = null != e ? e : n.nullContext || {},
                c = n.hooks.helperMissing,
                p = "function",
                m = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '<form name="leaveMessageForm" method="post" action="" onsubmit="preencher()">\n    <input type="hidden" name="style" value="' + i(s(null != (o = null != e ? m(e, "page") : e) ? m(o, "style") : o, e)) + '"/>\n    <input type="hidden" name="info" value="' + i((r = null != (r = m(l, "info") || (null != e ? m(e, "info") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "info",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 44
                    },
                    end: {
                        line: 3,
                        column: 52
                    }
                }
            }) : r)) + '"/>\n    <input type="hidden" name="referrer" value="' + i((r = null != (r = m(l, "referrer") || (null != e ? m(e, "referrer") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "referrer",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 4,
                        column: 48
                    },
                    end: {
                        line: 4,
                        column: 60
                    }
                }
            }) : r)) + '"/>\n    ' + (null != (o = m(l, "unless").call(u, null != e ? m(e, "groups") : e, {
                name: "unless",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 5,
                        column: 4
                    },
                    end: {
                        line: 5,
                        column: 110
                    }
                }
            })) ? o : "") + '\n\n    <div class="errors"></div>\n\n    <table cellspacing="1" cellpadding="5" border="0" class="form">\n        <tr>\n            <td><strong>' + i((m(l, "l10n") || e && m(e, "l10n") || c).call(u, "Your email", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 11,
                        column: 24
                    },
                    end: {
                        line: 11,
                        column: 45
                    }
                }
            })) + ':</strong></td>\n            <td><input type="text" name="email" size="50" value="' + i((r = null != (r = m(l, "email") || (null != e ? m(e, "email") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "email",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 12,
                        column: 65
                    },
                    end: {
                        line: 12,
                        column: 74
                    }
                }
            }) : r)) + '" class="username"/></td>\n        </tr>\n        <tr>\n            <td><strong>' + i((m(l, "l10n") || e && m(e, "l10n") || c).call(u, "Your name", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 15,
                        column: 24
                    },
                    end: {
                        line: 15,
                        column: 44
                    }
                }
            })) + ':</strong></td>\n            <td><input type="text" name="name" size="50" value="' + i((r = null != (r = m(l, "name") || (null != e ? m(e, "name") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "name",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 16,
                        column: 64
                    },
                    end: {
                        line: 16,
                        column: 72
                    }
                }
            }) : r)) + '" class="username"/></td>\n        </tr>\n' + (null != (o = m(l, "if").call(u, null != e ? m(e, "groups") : e, {
                name: "if",
                hash: {},
                fn: n.program(4, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 18,
                        column: 4
                    },
                    end: {
                        line: 35,
                        column: 11
                    }
                }
            })) ? o : "") + "        <tr>\n            <td><strong>" + i((m(l, "l10n") || e && m(e, "l10n") || c).call(u, "Message", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 37,
                        column: 24
                    },
                    end: {
                        line: 37,
                        column: 42
                    }
                }
            })) + ':</strong></td>\n            <td valign="top">\n                <textarea id="message-leave" name="message" tabindex="0" cols="40" rows="5">' + i((r = null != (r = m(l, "message") || (null != e ? m(e, "message") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "message",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 39,
                        column: 92
                    },
                    end: {
                        line: 39,
                        column: 103
                    }
                }
            }) : r)) + "</textarea>\n            </td>\n        </tr>\n" + (null != (o = m(l, "if").call(u, null != e ? m(e, "showCaptcha") : e, {
                name: "if",
                hash: {},
                fn: n.program(11, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 42,
                        column: 4
                    },
                    end: {
                        line: 47,
                        column: 11
                    }
                }
            })) ? o : "") + (null != (o = m(l, "if").call(u, null != e ? m(e, "privacyPolicyUrl") : e, {
                name: "if",
                hash: {},
                fn: n.program(13, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 48,
                        column: 4
                    },
                    end: {
                        line: 52,
                        column: 11
                    }
                }
            })) ? o : "") + '    </table>\n    <a href="javascript:void(0);" class="form-button" id="send-message">' + i((m(l, "l10n") || e && m(e, "l10n") || c).call(u, "Send", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 54,
                        column: 72
                    },
                    end: {
                        line: 54,
                        column: 87
                    }
                }
            })) + '</a>\n    <div class="clear">&nbsp;</div>\n</form>\n<div id="ajax-loader"><img src="' + i(s(null != (o = null != e ? m(e, "page") : e) ? m(o, "stylePath") : o, e)) + '/images/ajax-loader.gif" alt="Loading..." /></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["leave_message/layout"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return (null != (o = n.invokePartial(r(a, "_logo"), e, {
                name: "_logo",
                data: t,
                helpers: l,
                partials: a,
                decorators: n.decorators
            })) ? o : "") + '\n<div id="headers">\n    <div class="headers-inwards-wrapper-common"><div class="headers-inwards-wrapper-left"><div class="headers-inwards-wrapper-right"><div class="headers-inwards-wrapper-top"><div class="headers-inwards-wrapper-top-left"><div class="headers-inwards-wrapper-top-right"><div class="headers-inwards-wrapper-bottom-left"><div class="headers-inwards-wrapper-bottom-right" id="description-region">\n    </div></div></div></div></div></div></div></div>\n</div>\n\n<div id="content-wrapper"></div>'
        },
        usePartial: !0,
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["leave_message/sent_description"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '<div class="buttons">\n        <a href="javascript:Supdesk.Utils.closeChatPopup();" title="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Close...", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 66
                    },
                    end: {
                        line: 2,
                        column: 85
                    }
                }
            })) + '">\n            <img class="tpl-image image-close-window" src="' + i(n.lambda(null != (o = null != e ? u(e, "page") : e) ? u(o, "stylePath") : o, e)) + '/images/free.gif" alt="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Close...", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 100
                    },
                    end: {
                        line: 3,
                        column: 119
                    }
                }
            })) + '" />\n        </a>\n</div>\n<div class="info-message">' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Thank you for your message. We'll answer your query by email as soon as possible.", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 6,
                        column: 26
                    },
                    end: {
                        line: 6,
                        column: 118
                    }
                }
            })) + "</div>"
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["survey/form"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<input type="hidden" name="email" value="' + n.escapeExpression((o = null != (o = r(l, "email") || (null != e ? r(e, "email") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "email",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 6,
                        column: 66
                    },
                    end: {
                        line: 6,
                        column: 75
                    }
                }
            }) : o)) + '"/>'
        },
        3: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? r(e, "groupId") : e, {
                name: "if",
                hash: {},
                fn: n.program(4, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 7,
                        column: 22
                    },
                    end: {
                        line: 7,
                        column: 99
                    }
                }
            })) ? o : ""
        },
        4: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<input type="hidden" name="group" value="' + n.escapeExpression((o = null != (o = r(l, "groupId") || (null != e ? r(e, "groupId") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "groupId",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 7,
                        column: 78
                    },
                    end: {
                        line: 7,
                        column: 89
                    }
                }
            }) : o)) + '"/>'
        },
        6: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<input type="hidden" name="message" value="' + n.escapeExpression((o = null != (o = r(l, "message") || (null != e ? r(e, "message") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "message",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 8,
                        column: 70
                    },
                    end: {
                        line: 8,
                        column: 81
                    }
                }
            }) : o)) + '"/>'
        },
        8: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "        <tr>\n            <td><strong>" + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Choose Department:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 15,
                        column: 24
                    },
                    end: {
                        line: 15,
                        column: 53
                    }
                }
            })) + '</strong></td>\n            <td>\n                <select name="group">\n' + (null != (o = u(l, "each").call(r, null != e ? u(e, "groups") : e, {
                name: "each",
                hash: {},
                fn: n.program(9, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 18,
                        column: 20
                    },
                    end: {
                        line: 20,
                        column: 29
                    }
                }
            })) ? o : "") + "                </select>\n            </td>\n        </tr>\n        <tr>\n            <td><strong>" + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Department description:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 25,
                        column: 24
                    },
                    end: {
                        line: 25,
                        column: 58
                    }
                }
            })) + '</strong></td>\n            <td id="group-description">' + (null != (o = u(l, "each").call(r, null != e ? u(e, "groups") : e, {
                name: "each",
                hash: {},
                fn: n.program(14, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 26,
                        column: 39
                    },
                    end: {
                        line: 26,
                        column: 112
                    }
                }
            })) ? o : "") + "</td>\n        </tr>\n"
        },
        9: function(n, e, l, a, t) {
            var o, r = n.lambda,
                s = n.escapeExpression,
                i = null != e ? e : n.nullContext || {},
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '                        <option value="' + s(r(null != e ? u(e, "id") : e, e)) + '" ' + (null != (o = u(l, "if").call(i, null != e ? u(e, "selected") : e, {
                name: "if",
                hash: {},
                fn: n.program(10, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 19,
                        column: 52
                    },
                    end: {
                        line: 19,
                        column: 99
                    }
                }
            })) ? o : "") + ">" + s(r(null != e ? u(e, "name") : e, e)) + (null != (o = u(l, "unless").call(i, null != e ? u(e, "online") : e, {
                name: "unless",
                hash: {},
                fn: n.program(12, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 19,
                        column: 113
                    },
                    end: {
                        line: 19,
                        column: 157
                    }
                }
            })) ? o : "") + "</option>\n"
        },
        10: function(n, e, l, a, t) {
            return 'selected="selected"'
        },
        12: function(n, e, l, a, t) {
            return " (offline)"
        },
        14: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? r(e, "selected") : e, {
                name: "if",
                hash: {},
                fn: n.program(15, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 26,
                        column: 55
                    },
                    end: {
                        line: 26,
                        column: 103
                    }
                }
            })) ? o : ""
        },
        15: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression(n.lambda(null != e ? o(e, "description") : e, e))
        },
        17: function(n, e, l, a, t) {
            return 'disabled="disabled"'
        },
        19: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "        <tr>\n            <td><strong>" + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Email:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 35,
                        column: 24
                    },
                    end: {
                        line: 35,
                        column: 41
                    }
                }
            })) + '</strong></td>\n            <td><input type="text" name="email" size="50" value="' + i((o = null != (o = u(l, "email") || (null != e ? u(e, "email") : e)) ? o : s, "function" == typeof o ? o.call(r, {
                name: "email",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 36,
                        column: 65
                    },
                    end: {
                        line: 36,
                        column: 74
                    }
                }
            }) : o)) + '" class="username"/></td>\n        </tr>\n'
        },
        21: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return "        <tr>\n            <td><strong>" + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Initial Question:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 41,
                        column: 24
                    },
                    end: {
                        line: 41,
                        column: 52
                    }
                }
            })) + '</strong></td>\n            <td valign="top"><textarea id="message-survey" name="message" tabindex="0" cols="45" rows="2">' + i((o = null != (o = u(l, "message") || (null != e ? u(e, "message") : e)) ? o : s, "function" == typeof o ? o.call(r, {
                name: "message",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 42,
                        column: 106
                    },
                    end: {
                        line: 42,
                        column: 117
                    }
                }
            }) : o)) + "</textarea></td>\n        </tr>\n"
        },
        23: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '        <tr>\n            <td colspan="2"><strong>' + (null != (o = (r(l, "l10n") || e && r(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, 'Please note that by starting the chat you\'re explicitly agree with the <a href="{0}" target="_blank">Privacy Policy</a>', null != e ? r(e, "privacyPolicyUrl") : e, {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 47,
                        column: 36
                    },
                    end: {
                        line: 47,
                        column: 189
                    }
                }
            })) ? o : "") + "</strong></td>\n        </tr>\n"
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r, s = n.lambda,
                i = n.escapeExpression,
                u = null != e ? e : n.nullContext || {},
                c = n.hooks.helperMissing,
                p = "function",
                m = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '<form name="surveyForm" method="post" action="">\n    <input type="hidden" name="style" value="' + i(s(null != (o = null != e ? m(e, "page") : e) ? m(o, "style") : o, e)) + '"/>\n    <input type="hidden" name="info" value="' + i((r = null != (r = m(l, "info") || (null != e ? m(e, "info") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "info",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 44
                    },
                    end: {
                        line: 3,
                        column: 52
                    }
                }
            }) : r)) + '"/>\n    <input type="hidden" name="referrer" value="' + i((r = null != (r = m(l, "referrer") || (null != e ? m(e, "referrer") : e)) ? r : c, typeof r === p ? r.call(u, {
                name: "referrer",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 4,
                        column: 48
                    },
                    end: {
                        line: 4,
                        column: 60
                    }
                }
            }) : r)) + '"/>\n    <input type="hidden" name="survey" value="on"/>\n    ' + (null != (o = m(l, "unless").call(u, null != e ? m(e, "showEmail") : e, {
                name: "unless",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 6,
                        column: 4
                    },
                    end: {
                        line: 6,
                        column: 89
                    }
                }
            })) ? o : "") + "\n    " + (null != (o = m(l, "unless").call(u, null != e ? m(e, "groups") : e, {
                name: "unless",
                hash: {},
                fn: n.program(3, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 7,
                        column: 4
                    },
                    end: {
                        line: 7,
                        column: 110
                    }
                }
            })) ? o : "") + "\n    " + (null != (o = m(l, "unless").call(u, null != e ? m(e, "showMessage") : e, {
                name: "unless",
                hash: {},
                fn: n.program(6, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 8,
                        column: 4
                    },
                    end: {
                        line: 8,
                        column: 95
                    }
                }
            })) ? o : "") + '\n\n    <div class="errors"></div>\n\n    <table class="form">\n' + (null != (o = m(l, "if").call(u, null != e ? m(e, "groups") : e, {
                name: "if",
                hash: {},
                fn: n.program(8, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 13,
                        column: 4
                    },
                    end: {
                        line: 28,
                        column: 11
                    }
                }
            })) ? o : "") + "        <tr>\n            <td><strong>" + i((m(l, "l10n") || e && m(e, "l10n") || c).call(u, "Name:", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 30,
                        column: 24
                    },
                    end: {
                        line: 30,
                        column: 40
                    }
                }
            })) + '</strong></td>\n            <td><input type="text" name="name" size="50" value="" class="username" ' + (null != (o = m(l, "unless").call(u, null != e ? m(e, "canChangeName") : e, {
                name: "unless",
                hash: {},
                fn: n.program(17, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 31,
                        column: 91
                    },
                    end: {
                        line: 31,
                        column: 146
                    }
                }
            })) ? o : "") + "/></td>\n        </tr>\n" + (null != (o = m(l, "if").call(u, null != e ? m(e, "showEmail") : e, {
                name: "if",
                hash: {},
                fn: n.program(19, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 33,
                        column: 4
                    },
                    end: {
                        line: 38,
                        column: 11
                    }
                }
            })) ? o : "") + (null != (o = m(l, "if").call(u, null != e ? m(e, "showMessage") : e, {
                name: "if",
                hash: {},
                fn: n.program(21, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 39,
                        column: 4
                    },
                    end: {
                        line: 44,
                        column: 11
                    }
                }
            })) ? o : "") + (null != (o = m(l, "if").call(u, null != e ? m(e, "privacyPolicyUrl") : e, {
                name: "if",
                hash: {},
                fn: n.program(23, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 45,
                        column: 4
                    },
                    end: {
                        line: 49,
                        column: 11
                    }
                }
            })) ? o : "") + '    </table>\n    <br/>\n    <a href="javascript:void(0);" class="form-button" id="submit-survey">' + i((m(l, "l10n") || e && m(e, "l10n") || c).call(u, "Start Chat", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 52,
                        column: 73
                    },
                    end: {
                        line: 52,
                        column: 94
                    }
                }
            })) + '</a>\n    <div class="clear">&nbsp;</div>\n</form>\n<div id="ajax-loader"><img src="' + i(s(null != (o = null != e ? m(e, "page") : e) ? m(o, "stylePath") : o, e)) + '/images/ajax-loader.gif" alt="Loading..." /></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["survey/layout"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return (null != (o = n.invokePartial(u(a, "_logo"), e, {
                name: "_logo",
                data: t,
                helpers: l,
                partials: a,
                decorators: n.decorators
            })) ? o : "") + '\n<div id="headers">\n    <div class="headers-inwards-wrapper-common"><div class="headers-inwards-wrapper-left"><div class="headers-inwards-wrapper-right"><div class="headers-inwards-wrapper-top"><div class="headers-inwards-wrapper-top-left"><div class="headers-inwards-wrapper-top-right"><div class="headers-inwards-wrapper-bottom-left"><div class="headers-inwards-wrapper-bottom-right">\n        <div class="buttons">\n            <a href="javascript:Supdesk.Utils.closeChatPopup();" title="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Close", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 8,
                        column: 70
                    },
                    end: {
                        line: 8,
                        column: 86
                    }
                }
            })) + '"><img class="tpl-image image-close-window" src="' + i(n.lambda(null != (o = null != e ? u(e, "page") : e) ? u(o, "stylePath") : o, e)) + '/images/free.gif" alt="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Close", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 8,
                        column: 176
                    },
                    end: {
                        line: 8,
                        column: 192
                    }
                }
            })) + '" /></a>\n        </div>\n        <div class="info-message">' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Thank you for contacting us. Please fill out the form below and click the Start Chat button.", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 10,
                        column: 34
                    },
                    end: {
                        line: 10,
                        column: 137
                    }
                }
            })) + '</div>\n    </div></div></div></div></div></div></div></div>\n</div>\n\n<div id="content-wrapper"></div>'
        },
        usePartial: !0,
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/close"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<div class="tpl-image" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Close chat", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 30
                    },
                    end: {
                        line: 1,
                        column: 51
                    }
                }
            })) + '"></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/history"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<div class="tpl-image" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Visit history", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 30
                    },
                    end: {
                        line: 1,
                        column: 54
                    }
                }
            })) + '"></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/redirect"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<div class="tpl-image" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Redirect visitor to another operator", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 30
                    },
                    end: {
                        line: 2,
                        column: 77
                    }
                }
            })) + '"></div>\n'
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != (o = null != e ? r(e, "user") : e) ? r(o, "canPost") : o, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 3,
                        column: 7
                    }
                }
            })) ? o : ""
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/refresh"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<div class="tpl-image" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Refresh", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 30
                    },
                    end: {
                        line: 1,
                        column: 48
                    }
                }
            })) + '"></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/secure_mode"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            return '<div class="tpl-image" title="SSL"></div>'
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/send_mail"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '<div class="tpl-image" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Send chat history by e-mail", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 30
                    },
                    end: {
                        line: 2,
                        column: 68
                    }
                }
            })) + '"></div>\n'
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != (o = null != e ? r(e, "user") : e) ? r(o, "canSendEmail") : o, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.noop,
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 3,
                        column: 7
                    }
                }
            })) ? o : ""
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/sound"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '    <div class="tpl-image sound-control-on" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Turn off sound", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 51
                    },
                    end: {
                        line: 2,
                        column: 76
                    }
                }
            })) + '"></div>\n'
        },
        3: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return '    <div class="tpl-image sound-control-off" title="' + n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Turn on sound", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 4,
                        column: 52
                    },
                    end: {
                        line: 4,
                        column: 76
                    }
                }
            })) + '"></div>\n'
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != e ? r(e, "enabled") : e, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.program(3, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 5,
                        column: 7
                    }
                }
            })) ? o : ""
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/controls/user_name"] = Handlebars.template({
        1: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '    <span class="user-name-control-prefix">' + n.escapeExpression((s(l, "l10n") || e && s(e, "l10n") || n.hooks.helperMissing).call(r, "You are", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 2,
                        column: 43
                    },
                    end: {
                        line: 2,
                        column: 61
                    }
                }
            })) + "</span>\n" + (null != (o = s(l, "if").call(r, null != e ? s(e, "nameInput") : e, {
                name: "if",
                hash: {},
                fn: n.program(2, t, 0),
                inverse: n.program(4, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 3,
                        column: 4
                    },
                    end: {
                        line: 9,
                        column: 11
                    }
                }
            })) ? o : "")
        },
        2: function(n, e, l, a, t) {
            var o, r = n.escapeExpression,
                s = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '        <div class="user-name-control-input-background"><input id="user-name-control-input" type="text" size="12" value="' + r(n.lambda(null != (o = null != e ? s(e, "user") : e) ? s(o, "name") : o, e)) + '" class="username" /></div>\n        <a href="javascript:void(0)" class="user-name-control-set tpl-image" title="' + r((s(l, "l10n") || e && s(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Change name", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 5,
                        column: 84
                    },
                    end: {
                        line: 5,
                        column: 106
                    }
                }
            })) + '"></a>\n'
        },
        4: function(n, e, l, a, t) {
            var o, r = null != e ? e : n.nullContext || {},
                s = n.hooks.helperMissing,
                i = n.escapeExpression,
                u = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return '        <a href="javascript:void(0)" title="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Change name", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 7,
                        column: 44
                    },
                    end: {
                        line: 7,
                        column: 66
                    }
                }
            })) + '">' + i(n.lambda(null != (o = null != e ? u(e, "user") : e) ? u(o, "name") : o, e)) + '</a>\n        <a class="user-name-control-change tpl-image" title="' + i((u(l, "l10n") || e && u(e, "l10n") || s).call(r, "Change name", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 8,
                        column: 61
                    },
                    end: {
                        line: 8,
                        column: 83
                    }
                }
            })) + '"></a>\n'
        },
        6: function(n, e, l, a, t) {
            var o, r = n.escapeExpression,
                s = n.lookupProperty || function(n, e) {
                    if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
                };
            return r((s(l, "l10n") || e && s(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "You are", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 11,
                        column: 0
                    },
                    end: {
                        line: 11,
                        column: 18
                    }
                }
            })) + "&nbsp;" + r(n.lambda(null != (o = null != e ? s(e, "user") : e) ? s(o, "name") : o, e)) + "\n"
        },
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return null != (o = r(l, "if").call(null != e ? e : n.nullContext || {}, null != (o = null != e ? r(e, "user") : e) ? r(o, "canChangeName") : o, {
                name: "if",
                hash: {},
                fn: n.program(1, t, 0),
                inverse: n.program(6, t, 0),
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 12,
                        column: 7
                    }
                }
            })) ? o : ""
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/status/base"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression((o = null != (o = r(l, "title") || (null != e ? r(e, "title") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "title",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 1,
                        column: 9
                    }
                }
            }) : o))
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/status/message"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o, r = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression((o = null != (o = r(l, "message") || (null != e ? r(e, "message") : e)) ? o : n.hooks.helperMissing, "function" == typeof o ? o.call(null != e ? e : n.nullContext || {}, {
                name: "message",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 1,
                        column: 11
                    }
                }
            }) : o))
        },
        useData: !0
    })
}(),
function() {
    Handlebars.templates = Handlebars.templates || {};
    Handlebars.templates["chat/status/typing"] = Handlebars.template({
        compiler: [8, ">= 4.3.0"],
        main: function(n, e, l, a, t) {
            var o = n.lookupProperty || function(n, e) {
                if (Object.prototype.hasOwnProperty.call(n, e)) return n[e]
            };
            return n.escapeExpression((o(l, "l10n") || e && o(e, "l10n") || n.hooks.helperMissing).call(null != e ? e : n.nullContext || {}, "Remote user is typing...", {
                name: "l10n",
                hash: {},
                data: t,
                loc: {
                    start: {
                        line: 1,
                        column: 0
                    },
                    end: {
                        line: 1,
                        column: 35
                    }
                }
            }))
        },
        useData: !0
    })
}();