(window.webpackJsonp=window.webpackJsonp||[]).push([[8],{BNcT:function(t,n){},cPR9:function(t,n,e){"use strict";e.r(n),e.d(n,"NotificationsModule",(function(){return J}));var i=e("ofXK"),s=e("tyNb"),a=e("LRXf"),o=(e("BNcT"),e("fXoL"));let c=(()=>{class t{constructor(t){this.http=t}getAll(t){return this.http.get(`notifications/${t}/subscriptions`)}updateUserSubscriptions(t,n){return this.http.put(`notifications/${t}/subscriptions`,{selections:n})}}return t.\u0275fac=function(n){return new(n||t)(o.dc(a.a))},t.\u0275prov=o.Pb({token:t,factory:t.\u0275fac,providedIn:"root"}),t})();var r=e("twBr"),l=e("i2dy"),b=e("2Vo4"),d=e("nYR2"),g=e("3E0/"),u=e("0EQZ"),p=e("kmQS"),h=e("N2vX"),f=e("3Pt+"),m=e("bTqV"),v=e("bSwM");function P(t,n){if(1&t){const t=o.ac();o.Zb(0,"div",11),o.Zb(1,"div",12),o.Pc(2),o.Yb(),o.Zb(3,"mat-checkbox",13),o.hc("change",(function(e){o.Ec(t);const i=n.$implicit,s=o.lc(3);return e?s.toggleAllRowsFor(i):null})),o.Yb(),o.Yb()}if(2&t){const t=n.$implicit,e=o.lc(3);o.Fb(2),o.Qc(t),o.Fb(1),o.tc("checked",e.allRowsSelectedFor(t))("indeterminate",e.selections[t].hasValue()&&!e.allRowsSelectedFor(t))("disabled","browser"===t&&!e.supportsBrowserNotifications)}}function w(t,n){if(1&t&&(o.Xb(0),o.Nc(1,P,4,4,"div",10),o.Wb()),2&t){const t=o.lc(2);o.Fb(1),o.tc("ngForOf",t.availableChannels)}}function O(t,n){if(1&t){const t=o.ac();o.Zb(0,"div",11),o.Zb(1,"mat-checkbox",16),o.hc("click",(function(n){return o.Ec(t),n.stopPropagation()}))("change",(function(e){o.Ec(t);const i=n.$implicit,s=o.lc().$implicit,a=o.lc(2);return e?a.selections[i].toggle(s.notif_id):null})),o.Yb(),o.Yb()}if(2&t){const t=n.$implicit,e=o.lc().$implicit,i=o.lc(2);o.Fb(1),o.tc("checked",i.selections[t].isSelected(e.notif_id))("disabled","browser"===t&&!i.supportsBrowserNotifications)}}function k(t,n){if(1&t&&(o.Zb(0,"div",14),o.Zb(1,"div",15),o.Pc(2),o.Yb(),o.Nc(3,O,2,2,"div",10),o.Yb()),2&t){const t=n.$implicit,e=n.last,i=o.lc(2);o.Jb("no-border",e),o.Fb(2),o.Qc(t.name),o.Fb(1),o.tc("ngForOf",i.availableChannels)}}function y(t,n){if(1&t&&(o.Zb(0,"div",5),o.Zb(1,"div",6),o.Zb(2,"div",7),o.Pc(3),o.Yb(),o.Nc(4,w,2,1,"ng-container",8),o.Yb(),o.Nc(5,k,4,4,"div",9),o.Yb()),2&t){const t=n.$implicit,e=n.first;o.Fb(3),o.Qc(t.group_name),o.Fb(1),o.tc("ngIf",e),o.Fb(1),o.tc("ngForOf",t.subscriptions)}}let F=(()=>{class t{constructor(t,n,e,i,s,a){this.route=t,this.api=n,this.currentUser=e,this.toast=i,this.cd=s,this.settings=a,this.loading$=new b.a(!1),this.supportsBrowserNotifications="Notification"in window,this.availableChannels=[],this.selections={},this.allNotifIds=[]}ngOnInit(){this.route.data.subscribe(t=>{this.subscriptions=t.api.subscriptions,this.availableChannels=t.api.available_channels,this.allNotifIds=t.api.all_notif_ids,this.availableChannels.forEach(n=>{this.selections[n]=new u.c(!0,t.api.selections[n])})}),"granted"!==Notification.permission&&this.bindToBrowserNotifSubscription()}toggleAllRowsFor(t){this.allRowsSelectedFor(t)?this.selections[t].clear():this.selections[t].select(...this.allNotifIds)}allRowsSelectedFor(t){return this.selections[t].selected.length===this.allNotifIds.length}saveSettings(){this.loading$.next(!0);const t=this.getPayload();this.api.updateUserSubscriptions(this.currentUser.get("id"),t).pipe(Object(d.a)(()=>this.loading$.next(!1))).subscribe(()=>{this.toast.open("Notification settings updated.")})}getPayload(){const t={};return Object.keys(this.selections).forEach(n=>{t[n]=this.selections[n].selected}),t}bindToBrowserNotifSubscription(){this.selections.browser.changed.pipe(Object(g.a)(1)).subscribe(t=>{t.added.length&&!t.removed.length&&("denied"===Notification.permission?(this.toast.open("Notifications blocked. Please enable them for this site from browser settings."),this.selections.browser.clear(),this.cd.markForCheck()):Notification.requestPermission().then(t=>{"granted"!==t&&(this.selections.browser.clear(),this.cd.markForCheck())}))})}}return t.\u0275fac=function(n){return new(n||t)(o.Tb(s.a),o.Tb(c),o.Tb(r.a),o.Tb(l.a),o.Tb(o.i),o.Tb(p.a))},t.\u0275cmp=o.Nb({type:t,selectors:[["notification-subscriptions"]],decls:7,vars:5,consts:[[1,"box-shadow",3,"menuPosition"],[1,"be-container"],[1,"table","material-panel",3,"ngSubmit"],["class","setting-group",4,"ngFor","ngForOf"],["mat-raised-button","","color","accent","trans","",1,"submit-button",3,"disabled"],[1,"setting-group"],[1,"row"],["trans","",1,"name-column","strong"],[4,"ngIf"],["class","row indent",3,"no-border",4,"ngFor","ngForOf"],["class","channel-column",4,"ngFor","ngForOf"],[1,"channel-column"],["trans","",1,"channel-name"],[3,"checked","indeterminate","disabled","change"],[1,"row","indent"],["trans","",1,"name-column"],[3,"checked","disabled","click","change"]],template:function(t,n){1&t&&(o.Ub(0,"material-navbar",0),o.Zb(1,"div",1),o.Zb(2,"form",2),o.hc("ngSubmit",(function(){return n.saveSettings()})),o.Nc(3,y,6,3,"div",3),o.Zb(4,"button",4),o.mc(5,"async"),o.Pc(6,"Save Settings"),o.Yb(),o.Yb(),o.Yb()),2&t&&(o.tc("menuPosition",n.settings.get("vebto.navbar.defaultPosition")),o.Fb(3),o.tc("ngForOf",n.subscriptions),o.Fb(1),o.tc("disabled",o.nc(5,3,n.loading$)))},directives:[h.a,f.J,f.u,f.v,i.s,m.b,i.t,v.a],pipes:[i.b],styles:["[_nghost-%COMP%]{display:block;background-color:var(--be-background-alternative);min-height:100vh}.be-container[_ngcontent-%COMP%]{padding-top:35px;padding-bottom:35px}.table[_ngcontent-%COMP%]{border-radius:4px}.setting-group[_ngcontent-%COMP%]{margin-bottom:10px}.row[_ngcontent-%COMP%]{display:flex;align-items:center;border-bottom:1px solid var(--be-divider-default);padding:10px}.row.no-border[_ngcontent-%COMP%]{border-bottom:none}.row.indent[_ngcontent-%COMP%]{padding-left:20px}.name-column[_ngcontent-%COMP%]{flex:1 1 auto}.strong[_ngcontent-%COMP%]{font-weight:500;font-size:1.5rem;align-self:flex-end}.channel-name[_ngcontent-%COMP%]{margin-bottom:10px}.channel-column[_ngcontent-%COMP%]{width:75px;text-align:center;text-transform:capitalize}.submit-button[_ngcontent-%COMP%]{margin-top:15px}"],changeDetection:0}),t})();var x=e("JIr8"),C=e("5+tZ"),_=e("EY2u"),N=e("LRne");let M=(()=>{class t{constructor(t,n,e){this.router=t,this.subscriptions=n,this.currentUser=e}resolve(t,n){return this.subscriptions.getAll(+this.currentUser.get("id")).pipe(Object(x.a)(()=>(this.router.navigate(["/account/settings"]),_.a)),Object(C.a)(t=>t?Object(N.a)(t):(this.router.navigate(["/account/settings"]),_.a)))}}return t.\u0275fac=function(n){return new(n||t)(o.dc(s.e),o.dc(c),o.dc(r.a))},t.\u0275prov=o.Pb({token:t,factory:t.\u0275fac,providedIn:"root"}),t})();var Y=e("f+iI"),Z=e("OnlV"),$=e("WWJw"),R=e("Rd8u");function S(t,n){if(1&t){const t=o.ac();o.Zb(0,"li"),o.Zb(1,"button",4),o.hc("click",(function(){o.Ec(t);const e=n.$implicit;return o.lc().selectPage(e)})),o.Pc(2),o.Yb(),o.Yb()}if(2&t){const t=n.$implicit,e=o.lc();o.Fb(1),o.Jb("active",e.currentPage===t),o.tc("disabled",e.disabled),o.Fb(1),o.Qc(t)}}let T=(()=>{class t{constructor(t){this.router=t,this.pageChanged=new o.p,this.disabled=!0}get shouldHide(){return this.numberOfPages<2}set pagination(t){t&&(this.numberOfPages=t.last_page>10?10:t.last_page,this.numberOfPages>1&&(this.iterator=Array.from(Array(this.numberOfPages).keys()).map(t=>t+1),this.currentPage=t.current_page))}selectPage(t){this.currentPage!==t&&(this.currentPage=t,this.pageChanged.next(t),this.router.navigate([],{queryParams:{page:t},replaceUrl:!0}))}nextPage(){const t=this.currentPage+1;this.selectPage(t<=this.numberOfPages?t:this.currentPage)}prevPage(){const t=this.currentPage-1;this.selectPage(t>=1?t:this.currentPage)}}return t.\u0275fac=function(n){return new(n||t)(o.Tb(s.e))},t.\u0275cmp=o.Nb({type:t,selectors:[["pagination-widget"]],hostVars:2,hostBindings:function(t,n){2&t&&o.Jb("hidden",n.shouldHide)},inputs:{disabled:"disabled",pagination:"pagination"},outputs:{pageChanged:"pageChanged"},decls:8,vars:3,consts:[[1,"page-numbers"],["type","button","mat-button","","trans","",1,"prev",3,"disabled","click"],[4,"ngFor","ngForOf"],["type","button","mat-button","","trans","",1,"next",3,"disabled","click"],["type","button","mat-flat-button","","color","gray",1,"page-number-button",3,"disabled","click"]],template:function(t,n){1&t&&(o.Zb(0,"ul",0),o.Zb(1,"li"),o.Zb(2,"button",1),o.hc("click",(function(){return n.prevPage()})),o.Pc(3,"Previous"),o.Yb(),o.Yb(),o.Nc(4,S,3,4,"li",2),o.Zb(5,"li"),o.Zb(6,"button",3),o.hc("click",(function(){return n.nextPage()})),o.Pc(7,"Next"),o.Yb(),o.Yb(),o.Yb()),2&t&&(o.Fb(2),o.tc("disabled",n.disabled),o.Fb(2),o.tc("ngForOf",n.iterator),o.Fb(2),o.tc("disabled",n.disabled))},directives:[m.b,R.a,i.s],styles:["[_nghost-%COMP%]{display:block}ul[_ngcontent-%COMP%]{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;width:100%}li[_ngcontent-%COMP%]{margin:0 3px 6px}.page-number-button[_ngcontent-%COMP%]{width:40px;height:40px;min-width:40px;line-height:40px;padding:0}.active[_ngcontent-%COMP%]{background-color:var(--be-accent-default);color:var(--be-accent-contrast)}.next[_ngcontent-%COMP%], .prev[_ngcontent-%COMP%]{color:var(--be-accent-default)}"],changeDetection:0}),t})();const I=[{path:"",component:(()=>{class t{constructor(t,n,e,i){this.settings=t,this.notifications=n,this.breakpoints=e,this.route=i,this.pagination$=new b.a(null)}ngOnInit(){this.loadPage(this.route.snapshot.queryParams.page||1)}loadPage(t){this.notifications.load({page:t,perPage:25}).subscribe(t=>{this.pagination$.next(t.pagination)})}markAsRead(t){this.pagination$.value.data.find(n=>n.id===t.id).read_at=t.read_at}}return t.\u0275fac=function(n){return new(n||t)(o.Tb(p.a),o.Tb(Y.a),o.Tb(Z.a),o.Tb(s.a))},t.\u0275cmp=o.Nb({type:t,selectors:[["notification-page"]],decls:8,vars:13,consts:[[3,"menuPosition"],[1,"be-container"],[3,"notifications","compact","markedAsRead"],[3,"pagination","disabled","pageChanged"]],template:function(t,n){if(1&t&&(o.Ub(0,"material-navbar",0),o.Zb(1,"div",1),o.Zb(2,"notification-list",2),o.hc("markedAsRead",(function(t){return n.markAsRead(t)})),o.mc(3,"async"),o.mc(4,"async"),o.Yb(),o.Zb(5,"pagination-widget",3),o.hc("pageChanged",(function(t){return n.loadPage(t)})),o.mc(6,"async"),o.mc(7,"async"),o.Yb(),o.Yb()),2&t){var e;const t=null==(e=o.nc(3,5,n.pagination$))?null:e.data;o.tc("menuPosition",n.settings.get("vebto.navbar.defaultPosition")),o.Fb(2),o.tc("notifications",t)("compact",o.nc(4,7,n.breakpoints.isMobile$)),o.Fb(3),o.tc("pagination",o.nc(6,9,n.pagination$))("disabled",o.nc(7,11,n.notifications.loading$))}},directives:[h.a,$.a,T],pipes:[i.b],styles:["[_nghost-%COMP%]{display:block;min-height:100vh;background-color:var(--be-background-alternative)}.be-container[_ngcontent-%COMP%]{padding-top:25px;padding-bottom:25px}pagination-widget[_ngcontent-%COMP%]{margin-top:35px}"],changeDetection:0}),t})()},{path:"settings",component:F,resolve:{api:M}}];let j=(()=>{class t{}return t.\u0275mod=o.Rb({type:t}),t.\u0275inj=o.Qb({factory:function(n){return new(n||t)},imports:[[s.i.forChild(I)],s.i]}),t})();var A=e("MKyN"),B=e("CXWK"),E=e("gFpt"),Q=e("6rvT");let U=(()=>{class t{}return t.\u0275mod=o.Rb({type:t}),t.\u0275inj=o.Qb({factory:function(n){return new(n||t)},imports:[[i.c,m.c,Q.a]]}),t})(),J=(()=>{class t{}return t.\u0275mod=o.Rb({type:t}),t.\u0275inj=o.Qb({factory:function(n){return new(n||t)},imports:[[i.c,f.n,f.D,j,E.a,A.a,B.a,U,v.b,m.c]]}),t})()}}]);