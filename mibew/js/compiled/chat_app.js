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
! function(e) {
    e.Regions = {}, e.Layouts = {}, e.Application = new Backbone.Marionette.Application
}(Mibew),
MibewAPIChatInteraction = function() {
        this.mandatoryArguments = function() {
            return {
                "*": {
                    threadId: null,
                    token: null,
                    "return": {},
                    references: {}
                },
                result: {
                    errorCode: 0
                }
            }
        }, this.getReservedFunctionsNames = function() {
            return ["result"]
        }
    }, MibewAPIChatInteraction.prototype = new MibewAPIInteraction,
    function(e) {
        e.Utils = e.Utils || {}, e.Utils.closeChatPopup = function() {
            window.parent && window.parent !== window && window.parent.postMessage ? window.parent.postMessage("mibew-chat-closed:" + window.name, "*") : window.close()
        }
    }(Mibew),
    function(e, t) {
        e.Models.BaseSoundManager = t.Model.extend({
            defaults: {
                enabled: !0
            },
            play: function(t) {
                this.get("enabled") && e.Utils.playSound(t)
            }
        })
    }(Mibew, Backbone),
    function(e, t) {
        e.Models.Status = e.Models.Base.extend({
            defaults: {
                visible: !0,
                weight: 0,
                hideTimeout: 4e3,
                title: ""
            },
            initialize: function() {
                this.hideTimer = null
            },
            autoHide: function(e) {
                var s = e || this.get("hideTimeout");
                this.hideTimer && clearTimeout(this.hideTimer), this.hideTimer = setTimeout(t.bind(function() {
                    this.set({
                        visible: !1
                    })
                }, this), s)
            }
        })
    }(Mibew, _),
    function(e) {
        e.Models.BaseSurveyForm = e.Models.Base.extend({
            defaults: {
                name: "",
                email: "",
                message: "",
                info: "",
                referrer: "",
                groupId: null,
                groups: null
            }
        })
    }(Mibew),
    function(e, t) {
        e.Models.Avatar = e.Models.Base.extend({
            defaults: {
                imageLink: !1
            },
            initialize: function() {
                this.registeredFunctions = [], this.registeredFunctions.push(e.Objects.server.registerFunction("setupAvatar", t.bind(this.apiSetupAvatar, this))), e.Objects.Models.thread.on("change:agentId", this.setFromThread, this)
            },
            finalize: function() {
                for (var t = 0; t < this.registeredFunctions.length; t++) e.Objects.server.unregisterFunction(this.registeredFunctions[t])
            },
            apiSetupAvatar: function(e) {
                this.set({
                    imageLink: e.imageLink || !1
                })
            },
            setFromThread: function(s) {
                return s.get("agentId") ? void e.Objects.server.callFunctions([{
                    "function": "getAvatar",
                    arguments: {
                        references: {},
                        "return": {
                            imageLink: "imageLink"
                        },
                        threadId: s.get("id"),
                        token: s.get("token")
                    }
                }], t.bind(this.apiSetupAvatar, this), !0) : void this.set({
                    imageLink: !1
                })
            }
        })
    }(Mibew, _),
    function(e, t) {
        e.Models.ChatUser = e.Models.User.extend({
            defaults: t.extend({}, e.Models.User.prototype.defaults, {
                canPost: !0,
                typing: !1,
                canChangeName: !1,
                defaultName: !0
            })
        })
    }(Mibew, _),
    function(e) {
        e.Models.CloseControl = e.Models.Control.extend({
            getModelType: function() {
                return "CloseControl"
            },
            closeThread: function() {
                var t = e.Objects.Models.thread,
                    s = e.Objects.Models.user;
                e.Objects.server.callFunctions([{
                    "function": "close",
                    arguments: {
                        references: {},
                        "return": {
                            closed: "closed"
                        },
                        threadId: t.get("id"),
                        token: t.get("token"),
                        lastId: t.get("lastId"),
                        user: !s.get("isAgent")
                    }
                }], function(t) {
                    t.closed ? e.Utils.closeChatPopup() : e.Objects.Models.Status.message.setMessage(t.errorMessage || "Cannot close")
                }, !0)
            }
        })
    }(Mibew),
    function(e, t) {
        e.Models.HistoryControl = e.Models.Control.extend({
            defaults: t.extend({}, e.Models.Control.prototype.defaults, {
                link: !1,
                windowParams: ""
            }),
            getModelType: function() {
                return "HistoryControl"
            }
        })
    }(Mibew, _),
    function(e, t) {
        e.Models.RedirectControl = e.Models.Control.extend({
            defaults: t.extend({}, e.Models.Control.prototype.defaults, {
                link: !1
            }),
            getModelType: function() {
                return "RedirectControl"
            }
        })
    }(Mibew, _),
    function(e) {
        e.Models.RefreshControl = e.Models.Control.extend({
            getModelType: function() {
                return "RefreshControl"
            },
            refresh: function() {
                e.Objects.server.restartUpdater()
            }
        })
    }(Mibew),
    function(e, t) {
        e.Models.SecureModeControl = e.Models.Control.extend({
            defaults: t.extend({}, e.Models.Control.prototype.defaults, {
                link: !1
            }),
            getModelType: function() {
                return "SecureModeControl"
            }
        })
    }(Mibew, _),
    function(e, t) {
        e.Models.SendMailControl = e.Models.Control.extend({
            defaults: t.extend({}, e.Models.Control.prototype.defaults, {
                link: !1,
                windowParams: ""
            }),
            getModelType: function() {
                return "SendMailControl"
            }
        })
    }(Mibew, _),
    function(e, t) {
        e.Models.SoundControl = e.Models.Control.extend({
            defaults: t.extend({}, e.Models.Control.prototype.defaults, {
                enabled: !0
            }),
            toggle: function() {
                var t = !this.get("enabled");
                e.Objects.Models.soundManager.set({
                    enabled: t
                }), this.set({
                    enabled: t
                })
            },
            getModelType: function() {
                return "SoundControl"
            }
        })
    }(Mibew, _),
    function(e) {
        e.Models.UserNameControl = e.Models.Control.extend({
            getModelType: function() {
                return "UserNameControl"
            },
            changeName: function(t) {
                var s = e.Objects.Models.user,
                    n = e.Objects.Models.thread,
                    o = s.get("name");
                t && o != t && (e.Objects.server.callFunctions([{
                    "function": "rename",
                    arguments: {
                        references: {},
                        "return": {},
                        threadId: n.get("id"),
                        token: n.get("token"),
                        name: t
                    }
                }], function(t) {
                    t.errorCode && (e.Objects.Models.Status.message.setMessage(t.errorMessage || "Cannot rename"), s.set({
                        name: o
                    }))
                }, !0), s.set({
                    name: t
                }))
            }
        })
    }(Mibew),
    function(e, t) {
        var s = e.Models.BaseSurveyForm;
        e.Models.LeaveMessageForm = s.extend({
            defaults: t.extend({}, s.prototype.defaults, {
                showCaptcha: !1,
                captcha: ""
            }),
            validate: function(t) {
                var s = e.Localization;
                if ("undefined" != typeof t.email) {
                    if (!t.email) return s.trans('Please fill "{0}".', s.trans("Your email"));
                    if (!e.Utils.checkEmail(t.email)) return s.trans('Please fill "{0}" correctly.', s.trans("Your email"))
                }
                return "undefined" == typeof t.name || t.name ? "undefined" == typeof t.message || t.message ? this.get("showCaptcha") && "undefined" != typeof t.captcha && !t.captcha ? s.trans("The letters you typed don't match the letters that were shown in the picture.") : void 0 : s.trans('Please fill "{0}".', s.trans("Message")) : s.trans('Please fill "{0}".', s.trans("Your name"))
            },
            submit: function() {
                if (!this.validate(this.attributes)) {
                    var t = this;
                    e.Objects.server.callFunctions([{
                        "function": "processLeaveMessage",
                        arguments: {
                            references: {},
                            "return": {},
                            groupId: t.get("groupId"),
                            name: t.get("name"),
                            info: t.get("info"),
                            email: t.get("email"),
                            message: t.get("message"),
                            referrer: t.get("referrer"),
                            captcha: t.get("captcha"),
                            threadId: null,
                            token: null
                        }
                    }], function(e) {
                        0 == e.errorCode ? t.trigger("submit:complete", t) : t.trigger("submit:error", t, {
                            code: e.errorCode,
                            message: e.errorMessage || ""
                        })
                    }, !0)
                }
            },
            ERROR_WRONG_CAPTCHA: 10
        })
    }(Mibew, _),
    function(e) {
        e.Models.MessageForm = e.Models.Base.extend({
            defaults: {
                predefinedAnswers: [],
                ignoreCtrl: !1
            },
            postMessage: function(t) {
                var s = e.Objects.Models.thread,
                    n = e.Objects.Models.user;
                if (n.get("canPost")) {
                    this.trigger("before:post", this);
                    var o = this;
                    e.Objects.server.callFunctions([{
                        "function": "post",
                        arguments: {
                            references: {},
                            "return": {},
                            message: t,
                            threadId: s.get("id"),
                            token: s.get("token"),
                            user: !n.get("isAgent")
                        }
                    }], function() {
                        o.trigger("after:post", o)
                    }, !0)
                }
            }
        })
    }(Mibew),
    function(e, t) {
        e.Models.ChatSoundManager = e.Models.BaseSoundManager.extend({
            defaults: t.extend({}, e.Models.BaseSoundManager.prototype.defaults, {
                skipNextMessageSound: !1
            }),
            initialize: function() {
                var t = e.Objects,
                    s = this;
                t.Collections.messages.on("multiple:add", this.playNewMessageSound, this), t.Models.messageForm.on("before:post", function() {
                    s.set({
                        skipNextMessageSound: !0
                    })
                })
            },
            playNewMessageSound: function() {
                if (!this.get("skipNextMessageSound")) {
                    var t = e.Objects.Models.page.get("mibewBasePath");
                    "undefined" != typeof t && (t += "/sounds/new_message", this.play(t))
                }
                this.set({
                    skipNextMessageSound: !1
                })
            }
        })
    }(Mibew, _),
    function(e, t) {
        e.Models.StatusMessage = e.Models.Status.extend({
            defaults: t.extend({}, e.Models.Status.prototype.defaults, {
                message: "",
                visible: !1
            }),
            getModelType: function() {
                return "StatusMessage"
            },
            setMessage: function(e) {
                this.set({
                    message: e,
                    visible: !0
                }), this.autoHide()
            }
        })
    }(Mibew, _),
    function(e, t) {
        e.Models.StatusTyping = e.Models.Status.extend({
            defaults: t.extend({}, e.Models.Status.prototype.defaults, {
                visible: !1,
                hideTimeout: 2e3
            }),
            getModelType: function() {
                return "StatusTyping"
            },
            show: function() {
                this.set({
                    visible: !0
                }), this.autoHide()
            }
        })
    }(Mibew, _),
    function(e, t) {
        var s = e.Models.BaseSurveyForm;
        e.Models.SurveyForm = s.extend({
            defaults: t.extend({}, s.prototype.defaults, {
                showEmail: !1,
                showMessage: !1,
                canChangeName: !1
            }),
            validate: function(t) {
                if (this.get("canChangeName") && "undefined" != typeof t.name) {
                    var s = t.name.replace(/^\s+/, "").replace(/\s+$/, "");
                    if (0 === s.length) 
					{
						return e.Localization.trans("Digite seu nome, por favor!")
						alert('Digite seu nome, por favor!');
						return false
					}
                }
                if (this.get("showEmail") && "undefined" != typeof t.email && !e.Utils.checkEmail(t.email)) return e.Localization.trans("Wrong email address.")
            },
            submit: function() {
                if (!this.validate(this.attributes)) {
                    var t = this;
                    e.Objects.server.callFunctions([{
                        "function": "processSurvey",
                        arguments: {
                            references: {},
                            "return": {
                                next: "next",
                                options: "options"
                            },
                            groupId: t.get("groupId"),
                            name: t.get("name"),
                            info: t.get("info"),
                            email: t.get("email"),
                            message: t.get("message"),
                            referrer: t.get("referrer"),
                            threadId: null,
                            token: null
                        }
                    }], function(s) {
                        if (0 == s.errorCode) switch (t.trigger("submit:complete", t), e.Application.Survey.stop(), s.next) {
                            case "chat":
                                e.Application.Chat.start(s.options);
                                break;
                            case "leaveMessage":
                                e.Application.LeaveMessage.start(s.options);
                                break;
                            default:
                                throw new Error("Do not know how to continue!")
                        } else t.trigger("submit:error", t, {
                            code: s.errorCode,
                            message: s.errorMessage || ""
                        })
                    }, !0)
                }
            }
        })
    }(Mibew, _),
    function(e, t, s) {
        e.Collections.Messages = t.Collection.extend({
            model: e.Models.Message,
            initialize: function() {
                this.periodicallyCalled = [], this.periodicallyCalled.push(e.Objects.server.callFunctionsPeriodically(s.bind(this.updateMessagesFunctionBuilder, this), s.bind(this.updateMessages, this)))
            },
            finalize: function() {
                for (var t = 0; t < this.periodicallyCalled.length; t++) e.Objects.server.stopCallFunctionsPeriodically(this.periodicallyCalled[t])
            },
            updateMessages: function(t) {
                t.lastId && e.Objects.Models.thread.set({
                    lastId: t.lastId
                });
                for (var s, n, o, a, i = e.Models.Message.prototype.KIND_PLUGIN, r = [], l = 0, d = t.messages.length; l < d; l++) s = t.messages[l], s.kind == i ? "object" == typeof s.data && null !== s.data && (n = s.plugin || !1, o = "process:" + (n !== !1 ? n + ":" : "") + "plugin:message", a = {
                    messageData: s,
                    model: !1
                }, this.trigger(o, a), a.model && (a.model.get("id") || a.model.set({
                    id: s.id
                }), r.push(a.model))) : r.push(new e.Models.Message(s));
                r.length > 0 && this.add(r)
            },
            updateMessagesFunctionBuilder: function() {
                var t = e.Objects.Models.thread,
                    s = e.Objects.Models.user;
                return [{
                    "function": "updateMessages",
                    arguments: {
                        "return": {
                            messages: "messages",
                            lastId: "lastId"
                        },
                        references: {},
                        threadId: t.get("id"),
                        token: t.get("token"),
                        lastId: t.get("lastId"),
                        user: !s.get("isAgent")
                    }
                }]
            },
            add: function() {
                var e = Array.prototype.slice.apply(arguments),
                    s = t.Collection.prototype.add.apply(this, e);
                return this.trigger("multiple:add"), s
            }
        })
    }(Mibew, Backbone, _),
    function(e, t) {
        e.Collections.Status = t.Collection.extend({
            comparator: function(e) {
                return e.get("weight")
            }
        })
    }(Mibew, Backbone),
    function(e, t, s) {
        e.Views.Status = t.Marionette.ItemView.extend({
            template: s.templates["chat/status/base"],
            className: "status",
            modelEvents: {
                change: "render"
            },
            onBeforeRender: function() {
                this.model.get("visible") ? this.$el.show() : this.$el.hide()
            }
        })
    }(Mibew, Backbone, Handlebars),
    function(e, t) {
        e.Views.BaseSurveyForm = t.Marionette.ItemView.extend({
            events: {
                'change select[name="group"]': "changeGroupDescription",
                "submit form": "preventSubmit"
            },
            ui: {
                groupSelect: 'select[name="group"]',
                groupDescription: "#group-description",
                name: 'input[name="name"]',
                email: 'input[name="email"]',
                message: 'textarea[name="message"]',
                errors: ".errors",
                ajaxLoader: "#ajax-loader"
            },
            modelEvents: {
                invalid: "hideAjaxLoader showError",
                "submit:error": "hideAjaxLoader showError"
            },
            preventSubmit: function(e) {
                e.preventDefault()
            },
            changeGroupDescription: function() {
                var e = this.ui.groupSelect.prop("selectedIndex"),
                    t = this.model.get("groups")[e].description || "";
                this.ui.groupDescription.text(t)
            },
            showError: function(e, t) {
                var s;
                s = "string" == typeof t ? t : t.message, this.ui.errors.html(s)
            },
            serializeData: function() {
                var t = this.model.toJSON();
                return t.page = e.Objects.Models.page.toJSON(), t
            },
            showAjaxLoader: function() {
                this.ui.ajaxLoader.show()
            },
            hideAjaxLoader: function() {
                this.ui.ajaxLoader.hide()
            }
        })
    }(Mibew, Backbone),
    function(e, t, s) {
        e.Views.Avatar = t.Marionette.ItemView.extend({
            template: s.templates["chat/avatar"],
            className: "avatar",
            modelEvents: {
                change: "render"
            }
        })
    }(Mibew, Backbone, Handlebars),
    function(e, t, s) {
        e.Views.CloseControl = e.Views.Control.extend({
            template: t.templates["chat/controls/close"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "closeThread"
            }),
            closeThread: function() {
                var t = e.Localization.trans("Are you sure that you want to leave the chat?"),
                    s = this;
                t !== !1 && e.Utils.confirm(t, function(e) {
                    e && s.model.closeThread()
                })
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.HistoryControl = e.Views.Control.extend({
            template: t.templates["chat/controls/history"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "showHistory"
            }),
            showHistory: function() {
                var t = e.Objects.Models.user,
                    s = this.model.get("link");
                if (t.get("isAgent") && s) {
                    var n = e.Utils.buildWindowParams(this.model.get("windowParams"));
                    s = s.replace("&amp;", "&", "g");
                    var o = window.open(s, "UserHistory", n);
                    null !== o && (o.focus(), o.opener = window)
                }
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.RedirectControl = e.Views.Control.extend({
            template: t.templates["chat/controls/redirect"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "redirect"
            }),
            initialize: function() {
                e.Objects.Models.user.on("change", this.render, this)
            },
            serializeData: function() {
                var t = this.model.toJSON();
                return t.user = e.Objects.Models.user.toJSON(), t
            },
            redirect: function() {
                var t = e.Objects.Models.user;
                if (t.get("isAgent") && t.get("canPost")) {
                    var s = this.model.get("link");
                    if (s) {
                        var n = e.Objects.Models.page.get("style"),
                            o = "";
                        n && (o = (s.indexOf("?") === -1 ? "?" : "&") + "style=" + n), window.location.href = s.replace(/\&amp\;/g, "&") + o
                    }
                }
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.RefreshControl = e.Views.Control.extend({
            template: t.templates["chat/controls/refresh"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "refresh"
            }),
            refresh: function() {
                this.model.refresh()
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.SecureModeControl = e.Views.Control.extend({
            template: t.templates["chat/controls/secure_mode"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "secure"
            }),
            secure: function() {
                if ("https:" != window.location.protocol) {
                    var t = this.model.get("link");
                    if (t) {
                        var s = e.Objects.Models.page.get("style");
                        window.location.href = t.replace(/\&amp\;/g, "&") + (s ? (t.indexOf("?") > -1 ? "&" : "?") + "style=" + s : "")
                    }
                }
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.SendMailControl = e.Views.Control.extend({
            template: t.templates["chat/controls/send_mail"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "sendMail"
            }),
            serializeData: function() {
                var t = this.model.toJSON();
                return t.user = e.Objects.Models.user.toJSON(), t
            },
            sendMail: function() {
                var t = this.model.get("link"),
                    s = e.Objects.Models.page;
                if (t) {
                    var n = e.Utils.buildWindowParams(this.model.get("windowParams")),
                        o = s.get("style"),
                        a = "";
                    o && (a = (t.indexOf("?") === -1 ? "?" : "&") + "style=" + o), t = t.replace(/\&amp\;/g, "&") + a;
                    var i = window.open(t, "ForwardMail", n);
                    null !== i && (i.focus(), i.opener = window)
                }
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.SoundControl = e.Views.Control.extend({
            template: t.templates["chat/controls/sound"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                click: "toggle"
            }),
            toggle: function() {
                this.model.toggle()
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.UserNameControl = e.Views.Control.extend({
            template: t.templates["chat/controls/user_name"],
            events: s.extend({}, e.Views.Control.prototype.events, {
                "click .user-name-control-set": "changeName",
                "click .user-name-control-change": "showNameInput",
                "keydown #user-name-control-input": "inputKeyDown"
            }),
            ui: {
                nameInput: "#user-name-control-input"
            },
            initialize: function() {
                e.Objects.Models.user.on("change:name", this.hideNameInput, this), this.nameInput = e.Objects.Models.user.get("defaultName")
            },
            serializeData: function() {
                var t = this.model.toJSON();
                return t.user = e.Objects.Models.user.toJSON(), t.nameInput = this.nameInput, t
            },
            inputKeyDown: function(e) {
                var t = e.which;
                13 != t && 10 != t || this.changeName()
            },
            hideNameInput: function() {
                this.nameInput = !1, this.render()
            },
            showNameInput: function() {
                this.nameInput = !0, this.render()
            },
            changeName: function() {
                var e = this.ui.nameInput.val();
                this.model.changeName(e)
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.LeaveMessageDescription = t.Marionette.ItemView.extend({
            template: s.templates["leave_message/description"],
            serializeData: function() {
                return {
                    page: e.Objects.Models.page.toJSON()
                }
            }
        })
    }(Mibew, Backbone, Handlebars),
    function(e, t, s) {
        var n = e.Views.BaseSurveyForm;
        e.Views.LeaveMessageForm = n.extend({
            template: t.templates["leave_message/form"],
            events: s.extend({}, n.prototype.events, {
                "click #send-message": "submitForm"
            }),
            ui: s.extend({}, n.prototype.ui, {
                captcha: 'input[name="captcha"]',
                captchaImg: "#captcha-img"
            }),
            modelEvents: s.extend({}, n.prototype.modelEvents, {
                "submit:error": "hideAjaxLoader showError submitError"
            }),
            submitForm: function() {
                this.showAjaxLoader();
                var e = {};
                this.model.get("groups") && (e.groupId = this.ui.groupSelect.val()), e.name = this.ui.name.val() || "", e.email = this.ui.email.val() || "", e.message = this.ui.message.val() || "", this.model.get("showCaptcha") && (e.captcha = this.ui.captcha.val() || ""), this.model.set(e, {
                    validate: !0
                }), this.model.submit()
            },
            submitError: function(e, t) {
                if (t.code == e.ERROR_WRONG_CAPTCHA && e.get("showCaptcha")) {
                    var s = this.ui.captchaImg.attr("src");
                    s = s.replace(/\?d\=[0-9]+/, ""), this.ui.captchaImg.attr("src", s + "?d=" + (new Date).getTime())
                }
            }
        })
    }(Mibew, Handlebars, _),
    function(e, t, s) {
        e.Views.LeaveMessageSentDescription = t.Marionette.ItemView.extend({
            template: s.templates["leave_message/sent_description"],
            serializeData: function() {
                return {
                    page: e.Objects.Models.page.toJSON()
                }
            }
        })
    }(Mibew, Backbone, Handlebars),
    function(e, t, s) {
        e.Views.MessageForm = t.Marionette.ItemView.extend({
            template: s.templates["chat/message_form"],
            events: {
                "click #send-message": "postMessage",
                "keydown #message-input": "messageKeyDown",
                "keyup #message-input": "checkUserTyping",
                "change #message-input": "checkUserTyping",
                "change #predefined": "selectPredefinedAnswer"
            },
            modelEvents: {
                change: "render"
            },
            ui: {
                message: "#message-input",
                send: "#send-message",
                predefinedAnswer: "#predefined"
            },
            initialize: function() {
                e.Objects.Models.user.on("change:canPost", this.render, this)
            },
            serializeData: function() {
                var t = this.model.toJSON();
                return t.user = e.Objects.Models.user.toJSON(), t.sendShortcut = this.getSendShortcut(), t
            },
            postMessage: function() {
                if (!this.isDisabledInput()) {
                    var t = this.ui.message.val();
                    "" != t && (this.disableInput(), this.model.postMessage(t), e.Objects.Collections.messages.once("multiple:add", this.postMessageComplete, this))
                }
            },
            messageKeyDown: function(e) {
                var t = e.which,
                    s = e.ctrlKey;
                (13 == t && (s || this.model.get("ignoreCtrl")) || 10 == t) && this.postMessage()
            },
            enableInput: function() {
                this.ui.message.removeAttr("disabled")
            },
            disableInput: function() {
                this.ui.message.attr("disabled", "disabled")
            },
            isDisabledInput: function() {
                return "disabled" == this.ui.message.attr("disabled")
            },
            clearInput: function() {
                this.ui.message.val("").change()
            },
            postMessageComplete: function() {
                this.clearInput(), this.enableInput(), this.ui.message.focus()
            },
            selectPredefinedAnswer: function() {
                var e = this.ui.message,
                    t = this.ui.predefinedAnswer,
                    s = t.get(0).selectedIndex;
                s && (e.val(this.model.get("predefinedAnswers")[s - 1].full).change(), e.focus(), t.get(0).selectedIndex = 0)
            },
            checkUserTyping: function() {
                var t = e.Objects.Models.user,
                    s = "" != this.ui.message.val();
                s != t.get("typing") && t.set({
                    typing: s
                })
            },
            getSendShortcut: function() {
                return this.model.get("ignoreCtrl") ? "Enter" : navigator.userAgent.indexOf("mac") !== -1 ? "&#8984;-Enter" : "Ctrl-Enter"
            }
        })
    }(Mibew, Backbone, Handlebars),
    function(e, t) {
        e.Views.Message = e.Views.Message.extend({
            template: t.templates["chat/message"]
        })
    }(Mibew, Handlebars),
    function(e, t) {
        e.Views.StatusMessage = e.Views.Status.extend({
            template: t.templates["chat/status/message"]
        })
    }(Mibew, Handlebars),
    function(e, t) {
        e.Views.StatusTyping = e.Views.Status.extend({
            template: t.templates["chat/status/typing"]
        })
    }(Mibew, Handlebars),
    function(e, t, s) {
        var n = e.Views.BaseSurveyForm;
        e.Views.SurveyForm = n.extend({
            template: t.templates["survey/form"],
            events: s.extend({}, n.prototype.events, {
                "click #submit-survey": "submitForm"
            }),
            submitForm: function() {
                this.showAjaxLoader();
                var e = {};
                this.model.get("groups") && (e.groupId = this.ui.groupSelect.val()), this.model.get("canChangeName") && (e.name = this.ui.name.val() || ""), this.model.get("showEmail") && (e.email = this.ui.email.val() || ""), this.model.get("showMessage") && (e.message = this.ui.message.val() || ""), this.model.set(e, {
                    validate: !0
                }), this.model.submit()
            }
        })
    }(Mibew, Handlebars, _),
    function(e) {
        e.Views.MessagesCollection = e.Views.CollectionBase.extend({
            className: "messages-collection",
            getChildView: function(t) {
                return e.Views.Message
            }
        })
    }(Mibew),
    function(e) {
        e.Views.StatusCollection = e.Views.CollectionBase.extend({
            className: "status-collection",
            getChildView: function(t) {
                return e.Views.Status
            }
        })
    }(Mibew),
    function(e, t) {
        e.Regions.Messages = t.Marionette.Region.extend({
            onShow: function(e) {
                e.on("add:child", this.scrollToBottom, this)
            },
            scrollToBottom: function() {
                this.$el.scrollTop(this.$el.prop("scrollHeight"))
            }
        })
    }(Mibew, Backbone),
    function(e, t) {
        e.Layouts.Chat = t.Marionette.LayoutView.extend({
            template: Handlebars.templates["chat/layout"],
            regions: {
                controlsRegion: "#controls-region",
                avatarRegion: "#avatar-region",
                messagesRegion: {
                    selector: "#messages-region",
                    regionClass: e.Regions.Messages
                },
                statusRegion: "#status-region",
                messageFormRegion: "#message-form-region"
            },
            serializeData: function() {
                var t = e.Objects.Models;
                return {
                    page: t.page.toJSON(),
                    user: t.user.toJSON()
                }
            }
        })
    }(Mibew, Backbone),
    function(e, t) {
        e.Layouts.Invitation = t.Marionette.LayoutView.extend({
            template: Handlebars.templates["invitation/layout"],
            regions: {
                messagesRegion: {
                    selector: "#invitation-messages-region",
                    regionClass: e.Regions.Messages
                }
            }
        })
    }(Mibew, Backbone),
    function(e, t) {
        e.Layouts.LeaveMessage = t.Marionette.LayoutView.extend({
            template: Handlebars.templates["leave_message/layout"],
            regions: {
                leaveMessageFormRegion: "#content-wrapper",
                descriptionRegion: "#description-region"
            },
            serializeData: function() {
                return {
                    page: e.Objects.Models.page.toJSON()
                }
            }
        })
    }(Mibew, Backbone),
    function(e, t) {
        e.Layouts.Survey = t.Marionette.LayoutView.extend({
            template: Handlebars.templates["survey/layout"],
            regions: {
                surveyFormRegion: "#content-wrapper"
            },
            serializeData: function() {
                return {
                    page: e.Objects.Models.page.toJSON()
                }
            }
        })
    }(Mibew, Backbone),
    function(e) {
        e.Objects.Models.Controls = {}, e.Objects.Models.Status = {};
        var t = [],
            s = e.Application,
            n = s.module("Chat", {
                startWithParent: !1
            });
        n.addInitializer(function(n) {
            var o = e.Objects,
                a = e.Objects.Models,
                i = e.Objects.Models.Controls,
                r = e.Objects.Models.Status;
            n.page && a.page.set(n.page), a.thread = new e.Models.Thread(n.thread), a.user = new e.Models.ChatUser(n.user);
            var l = new e.Layouts.Chat;
            o.chatLayout = l, s.mainRegion.show(l);
            var d = new e.Collections.Controls;
            a.user.get("isAgent") || (i.userName = new e.Models.UserNameControl({
                weight: 220
            }), d.add(i.userName), i.sendMail = new e.Models.SendMailControl({
                weight: 200,
                link: n.links.mail,
                windowParams: n.windowsParams.mail
            }), d.add(i.sendMail)), a.user.get("isAgent") && (i.redirect = new e.Models.RedirectControl({
                weight: 200,
                link: n.links.redirect
            }), d.add(i.redirect), i.history = new e.Models.HistoryControl({
                weight: 180,
                link: n.links.history,
                windowParams: n.windowsParams.history
            }), d.add(i.history)), i.sound = new e.Models.SoundControl({
                weight: 160
            }), d.add(i.sound), i.refresh = new e.Models.RefreshControl({
                weight: 140
            }), d.add(i.refresh), n.links.ssl && (i.secureMode = new e.Models.SecureModeControl({
                weight: 120,
                link: n.links.ssl
            }), d.add(i.secureMode)), i.close = new e.Models.CloseControl({
                weight: 100
            }), d.add(i.close), o.Collections.controls = d, l.controlsRegion.show(new e.Views.ControlsCollection({
                collection: d
            })), r.message = new e.Models.StatusMessage({
                hideTimeout: 5e3
            }), r.typing = new e.Models.StatusTyping({
                hideTimeout: 5e3
            }), o.Collections.status = new e.Collections.Status([r.message, r.typing]), l.statusRegion.show(new e.Views.StatusCollection({
                collection: o.Collections.status
            })), a.user.get("isAgent") || (a.avatar = new e.Models.Avatar({
                imageLink: n.avatar || !1
            }), l.avatarRegion.show(new e.Views.Avatar({
                model: a.avatar
            }))), o.Collections.messages = new e.Collections.Messages, a.messageForm = new e.Models.MessageForm(n.messageForm), l.messageFormRegion.show(new e.Views.MessageForm({
                model: a.messageForm
            })), l.messagesRegion.show(new e.Views.MessagesCollection({
                collection: o.Collections.messages
            })), a.soundManager = new e.Models.ChatSoundManager, !a.user.get("isAgent") && n.links.chat && window.parent && window.parent.postMessage && window.parent !== window && window.parent.postMessage("mibew-chat-started:" + window.name + ":" + n.links.chat, "*"), t.push(o.server.callFunctionsPeriodically(function() {
                var t = e.Objects.Models.thread,
                    s = e.Objects.Models.user;
                return [{
                    "function": "update",
                    arguments: {
                        "return": {
                            threadState: "threadState",
                            threadAgentId: "threadAgentId",
                            typing: "typing",
                            canPost: "canPost"
                        },
                        references: {},
                        threadId: t.get("id"),
                        token: t.get("token"),
                        lastId: t.get("lastId"),
                        typed: s.get("typing"),
                        user: !s.get("isAgent")
                    }
                }]
            }, function(t) {
                return t.errorCode ? void e.Objects.Models.Status.message.setMessage(t.errorMessage || "refresh failed") : (t.typing && e.Objects.Models.Status.typing.show(), e.Objects.Models.user.set({
                    canPost: t.canPost || !1
                }), void e.Objects.Models.thread.set({
                    agentId: t.threadAgentId,
                    state: t.threadState
                }))
            }))
        }), n.on("start", function() {
            e.Objects.server.restartUpdater()
        }), n.addFinalizer(function() {
            e.Objects.chatLayout.destroy();
            for (var s = 0; s < t.length; s++) e.Objects.server.stopCallFunctionsPeriodically(t[s]);
            "undefined" != typeof e.Objects.Models.avatar && e.Objects.Models.avatar.finalize(), e.Objects.Collections.messages.finalize(), delete e.Objects.chatLayout, delete e.Objects.Models.thread, delete e.Objects.Models.user, delete e.Objects.Models.page, delete e.Objects.Models.avatar, delete e.Objects.Models.messageForm, delete e.Objects.Models.Controls, delete e.Objects.Models.Status, delete e.Objects.Collections.messages, delete e.Objects.Collections.controls, delete e.Objects.Collections.status
        })
    }(Mibew),
    function(e) {
        var t = [],
            s = e.Application,
            n = s.module("Invitation", {
                startWithParent: !1
            });
        n.addInitializer(function(n) {
            var o = e.Objects,
                a = e.Objects.Models;
            a.thread = new e.Models.Thread(n.thread), a.user = new e.Models.ChatUser(n.user), o.invitationLayout = new e.Layouts.Invitation, s.mainRegion.show(o.invitationLayout), o.Collections.messages = new e.Collections.Messages, o.invitationLayout.messagesRegion.show(new e.Views.MessagesCollection({
                collection: o.Collections.messages
            })), t.push(o.server.callFunctionsPeriodically(function() {
                var t = e.Objects.Models.thread;
                return [{
                    "function": "update",
                    arguments: {
                        "return": {},
                        references: {},
                        threadId: t.get("id"),
                        token: t.get("token"),
                        lastId: t.get("lastId"),
                        typed: !1,
                        user: !0
                    }
                }]
            }, function() {}))
        }), n.on("start", function() {
            e.Objects.server.restartUpdater()
        }), n.addFinalizer(function() {
            e.Objects.invitationLayout.destroy();
            for (var s = 0; s < t.length; s++) e.Objects.server.stopCallFunctionsPeriodically(t[s]);
            e.Objects.Collections.messages.finalize(), delete e.Objects.invitationLayout, delete e.Objects.Models.thread, delete e.Objects.Models.user, delete e.Objects.Collections.messages
        })
    }(Mibew),
    function(e) {
        var t = e.Application,
            s = t.module("LeaveMessage", {
                startWithParent: !1
            });
        s.addInitializer(function(s) {
            var n = e.Objects,
                o = e.Objects.Models;
            s.page && o.page.set(s.page), n.leaveMessageLayout = new e.Layouts.LeaveMessage, t.mainRegion.show(n.leaveMessageLayout), o.leaveMessageForm = new e.Models.LeaveMessageForm(s.leaveMessageForm), n.leaveMessageLayout.leaveMessageFormRegion.show(new e.Views.LeaveMessageForm({
                model: o.leaveMessageForm
            })), n.leaveMessageLayout.descriptionRegion.show(new e.Views.LeaveMessageDescription), o.leaveMessageForm.on("submit:complete", function() {
                n.leaveMessageLayout.leaveMessageFormRegion.empty(), n.leaveMessageLayout.descriptionRegion.empty(), n.leaveMessageLayout.descriptionRegion.show(new e.Views.LeaveMessageSentDescription)
            })
        }), s.addFinalizer(function() {
            e.Objects.leaveMessageLayout.destroy(), delete e.Objects.Models.leaveMessageForm
        })
    }(Mibew),
    function(e) {
        var t = e.Application,
            s = t.module("Survey", {
                startWithParent: !1
            });
        s.addInitializer(function(s) {
            var n = e.Objects,
                o = e.Objects.Models;
            n.surveyLayout = new e.Layouts.Survey, t.mainRegion.show(n.surveyLayout), o.surveyForm = new e.Models.SurveyForm(s.surveyForm), n.surveyLayout.surveyFormRegion.show(new e.Views.SurveyForm({
                model: o.surveyForm
            }))
        }), s.addFinalizer(function() {
            e.Objects.surveyLayout.destroy(), delete e.Objects.Models.surveyForm
        })
    }(Mibew),
    function(e, t) {
        var s = e.Application;
        s.addRegions({
            mainRegion: "#main-region"
        }), s.addInitializer(function(n) {
            switch (e.Objects.server = new e.Server(t.extend({
                    interactionType: MibewAPIChatInteraction
                }, n.server)), e.Objects.Models.page = new e.Models.Page(n.page), n.startFrom) {
                case "chat":
                    s.Chat.start(n.chatOptions);
                    break;
                case "survey":
                    s.Survey.start(n.surveyOptions);
                    break;
                case "leaveMessage":
                    s.LeaveMessage.start(n.leaveMessageOptions);
                    break;
                case "invitation":
                    s.Invitation.start(n.invitationOptions);
                    break;
                default:
                    throw new Error("Don't know how to start!")
            }
        }), s.on("start", function() {
            e.Objects.server.runUpdater()
        })
    }(Mibew, _);