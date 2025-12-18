webpackJsonp([1],Array(39).concat([
/* 39 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TablePlugin", function() { return TablePlugin; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableLitePlugin", function() { return TableLitePlugin; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "TableSimplePlugin", function() { return TableSimplePlugin; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__table__ = __webpack_require__(80);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__table_lite__ = __webpack_require__(100);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__table_simple__ = __webpack_require__(101);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__tbody__ = __webpack_require__(79);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__thead__ = __webpack_require__(75);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__tfoot__ = __webpack_require__(60);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__tr__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__td__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__th__ = __webpack_require__(61);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__utils_plugins__ = __webpack_require__(102);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTable", function() { return __WEBPACK_IMPORTED_MODULE_0__table__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTableLite", function() { return __WEBPACK_IMPORTED_MODULE_1__table_lite__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTableSimple", function() { return __WEBPACK_IMPORTED_MODULE_2__table_simple__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTbody", function() { return __WEBPACK_IMPORTED_MODULE_3__tbody__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BThead", function() { return __WEBPACK_IMPORTED_MODULE_4__thead__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTfoot", function() { return __WEBPACK_IMPORTED_MODULE_5__tfoot__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTr", function() { return __WEBPACK_IMPORTED_MODULE_6__tr__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTd", function() { return __WEBPACK_IMPORTED_MODULE_7__td__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "BTh", function() { return __WEBPACK_IMPORTED_MODULE_8__th__["a"]; });










var TableLitePlugin =
/*#__PURE__*/
Object(__WEBPACK_IMPORTED_MODULE_9__utils_plugins__["a" /* pluginFactory */])({
  components: {
    BTableLite: __WEBPACK_IMPORTED_MODULE_1__table_lite__["a" /* BTableLite */]
  }
});
var TableSimplePlugin =
/*#__PURE__*/
Object(__WEBPACK_IMPORTED_MODULE_9__utils_plugins__["a" /* pluginFactory */])({
  components: {
    BTableSimple: __WEBPACK_IMPORTED_MODULE_2__table_simple__["a" /* BTableSimple */],
    BTbody: __WEBPACK_IMPORTED_MODULE_3__tbody__["a" /* BTbody */],
    BThead: __WEBPACK_IMPORTED_MODULE_4__thead__["a" /* BThead */],
    BTfoot: __WEBPACK_IMPORTED_MODULE_5__tfoot__["a" /* BTfoot */],
    BTr: __WEBPACK_IMPORTED_MODULE_6__tr__["a" /* BTr */],
    BTd: __WEBPACK_IMPORTED_MODULE_7__td__["a" /* BTd */],
    BTh: __WEBPACK_IMPORTED_MODULE_8__th__["a" /* BTh */]
  }
});
var TablePlugin =
/*#__PURE__*/
Object(__WEBPACK_IMPORTED_MODULE_9__utils_plugins__["a" /* pluginFactory */])({
  components: {
    BTable: __WEBPACK_IMPORTED_MODULE_0__table__["a" /* BTable */]
  },
  plugins: {
    TableLitePlugin: TableLitePlugin,
    TableSimplePlugin: TableSimplePlugin
  }
});


/***/ }),
/* 40 */,
/* 41 */,
/* 42 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export toType */
/* unused harmony export toRawType */
/* unused harmony export toRawTypeLC */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return isUndefined; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return isNull; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return isUndefinedOrNull; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return isFunction; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return isBoolean; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return isString; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return isNumber; });
/* unused harmony export isPrimitive */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return isDate; });
/* unused harmony export isEvent */
/* unused harmony export isFile */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return isRegExp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return isPromise; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__object__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__safe_types__ = __webpack_require__(82);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__array__["d"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return __WEBPACK_IMPORTED_MODULE_1__object__["e"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return __WEBPACK_IMPORTED_MODULE_1__object__["f"]; });
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }



 // --- Convenience inspection utilities ---

var toType = function toType(val) {
  return _typeof(val);
};
var toRawType = function toRawType(val) {
  return Object.prototype.toString.call(val).slice(8, -1);
};
var toRawTypeLC = function toRawTypeLC(val) {
  return toRawType(val).toLowerCase();
};
var isUndefined = function isUndefined(val) {
  return val === undefined;
};
var isNull = function isNull(val) {
  return val === null;
};
var isUndefinedOrNull = function isUndefinedOrNull(val) {
  return isUndefined(val) || isNull(val);
};
var isFunction = function isFunction(val) {
  return toType(val) === 'function';
};
var isBoolean = function isBoolean(val) {
  return toType(val) === 'boolean';
};
var isString = function isString(val) {
  return toType(val) === 'string';
};
var isNumber = function isNumber(val) {
  return toType(val) === 'number';
};
var isPrimitive = function isPrimitive(val) {
  return isBoolean(val) || isString(val) || isNumber(val);
};
var isDate = function isDate(val) {
  return val instanceof Date;
};
var isEvent = function isEvent(val) {
  return val instanceof Event;
};
var isFile = function isFile(val) {
  return val instanceof __WEBPACK_IMPORTED_MODULE_2__safe_types__["a" /* File */];
};
var isRegExp = function isRegExp(val) {
  return toRawType(val) === 'RegExp';
};
var isPromise = function isPromise(val) {
  return !isUndefinedOrNull(val) && isFunction(val.then) && isFunction(val.catch);
}; // Extra convenience named re-exports



/***/ }),
/* 43 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
//
// Single point of contact for Vue
//
// TODO:
//   Conditionally import Vue if no global Vue
//

/* harmony default export */ __webpack_exports__["a"] = (__WEBPACK_IMPORTED_MODULE_0_vue___default.a);

/***/ }),
/* 44 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return from; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return isArray; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return arrayIncludes; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return concat; });
// --- Static ---
var from = Array.from;
var isArray = Array.isArray; // --- Instance ---

var arrayIncludes = function arrayIncludes(array, value) {
  return array.indexOf(value) !== -1;
};
var concat = function concat() {
  for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
    args[_key] = arguments[_key];
  }

  return Array.prototype.concat.apply([], args);
};

/***/ }),
/* 45 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export assign */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return getOwnPropertyNames; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return keys; });
/* unused harmony export defineProperties */
/* unused harmony export defineProperty */
/* unused harmony export freeze */
/* unused harmony export getOwnPropertyDescriptor */
/* unused harmony export getOwnPropertySymbols */
/* unused harmony export getPrototypeOf */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return create; });
/* unused harmony export isFrozen */
/* unused harmony export is */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return hasOwnProperty; });
/* unused harmony export toString */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return isObject; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return isPlainObject; });
/* unused harmony export omit */
/* unused harmony export readonlyDescriptor */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return deepFreeze; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(44);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

 // --- Static ---

var assign = Object.assign;
var getOwnPropertyNames = Object.getOwnPropertyNames;
var keys = Object.keys;
var defineProperties = Object.defineProperties;
var defineProperty = Object.defineProperty;
var freeze = Object.freeze;
var getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;
var getOwnPropertySymbols = Object.getOwnPropertySymbols;
var getPrototypeOf = Object.getPrototypeOf;
var create = Object.create;
var isFrozen = Object.isFrozen;
var is = Object.is; // --- "Instance" ---

var hasOwnProperty = function hasOwnProperty(obj, prop) {
  return Object.prototype.hasOwnProperty.call(obj, prop);
};
var toString = function toString(obj) {
  return Object.prototype.toString.call(obj);
}; // --- Utilities ---

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 * Note object could be a complex type like array, date, etc.
 */

var isObject = function isObject(obj) {
  return obj !== null && _typeof(obj) === 'object';
};
/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */

var isPlainObject = function isPlainObject(obj) {
  return Object.prototype.toString.call(obj) === '[object Object]';
}; // @link https://gist.github.com/bisubus/2da8af7e801ffd813fab7ac221aa7afc

var omit = function omit(obj, props) {
  return keys(obj).filter(function (key) {
    return props.indexOf(key) === -1;
  }).reduce(function (result, key) {
    return _objectSpread({}, result, _defineProperty({}, key, obj[key]));
  }, {});
};
var readonlyDescriptor = function readonlyDescriptor() {
  return {
    enumerable: true,
    configurable: false,
    writable: false
  };
};
/**
 * Deep-freezes and object, making it immutable / read-only.
 * Returns the same object passed-in, but frozen.
 * Freezes inner object/array/values first.
 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/freeze
 * Note: this method will not work for property values using Symbol() as a key
 */

var deepFreeze = function deepFreeze(obj) {
  // Retrieve the property names defined on object/array
  // Note: `keys` will ignore properties that are keyed by a `Symbol()`
  var props = keys(obj); // Iterate over each prop and recursively freeze it

  props.forEach(function (prop) {
    var value = obj[prop]; // If value is a plain object or array, we deepFreeze it

    obj[prop] = value && (isPlainObject(value) || Object(__WEBPACK_IMPORTED_MODULE_0__array__["d" /* isArray */])(value)) ? deepFreeze(value) : value;
  });
  return freeze(obj);
};

/***/ }),
/* 46 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_normalize_slot__ = __webpack_require__(81);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_array__ = __webpack_require__(44);


/* harmony default export */ __webpack_exports__["a"] = ({
  methods: {
    hasNormalizedSlot: function hasNormalizedSlot(names) {
      // Returns true if the either a $scopedSlot or $slot exists with the specified name
      // `names` can be a string name or an array of names
      return Object(__WEBPACK_IMPORTED_MODULE_0__utils_normalize_slot__["a" /* hasNormalizedSlot */])(names, this.$scopedSlots, this.$slots);
    },
    normalizeSlot: function normalizeSlot(names) {
      var scope = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

      // Returns an array of rendered VNodes if slot found.
      // Returns undefined if not found.
      // `names` can be a string name or an array of names
      var vNodes = Object(__WEBPACK_IMPORTED_MODULE_0__utils_normalize_slot__["b" /* normalizeSlot */])(names, scope, this.$scopedSlots, this.$slots);

      return vNodes ? Object(__WEBPACK_IMPORTED_MODULE_1__utils_array__["b" /* concat */])(vNodes) : vNodes;
    }
  }
});

/***/ }),
/* 47 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export props */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTr; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__ = __webpack_require__(46);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



var props = {
  variant: {
    type: String,
    default: null
  }
}; // @vue/component

var BTr =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTr',
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__["a" /* default */]],
  inheritAttrs: false,
  provide: function provide() {
    return {
      bvTableTr: this
    };
  },
  inject: {
    bvTableRowGroup: {
      defaut: function defaut()
      /* istanbul ignore next */
      {
        return {};
      }
    }
  },
  props: props,
  computed: {
    inTbody: function inTbody() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.isTbody;
    },
    inThead: function inThead() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.isThead;
    },
    inTfoot: function inTfoot() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.isTfoot;
    },
    isDark: function isDark() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.isDark;
    },
    isStacked: function isStacked() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.isStacked;
    },
    isResponsive: function isResponsive() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.isResponsive;
    },
    isStickyHeader: function isStickyHeader() {
      // Sniffed by <b-td> / <b-th>
      // Sticky headers are only supported in thead
      return this.bvTableRowGroup.isStickyHeader;
    },
    tableVariant: function tableVariant() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.tableVariant;
    },
    headVariant: function headVariant() {
      // Sniffed by <b-td> / <b-th>
      return this.bvTableRowGroup.headVariant;
    },
    trClasses: function trClasses() {
      return [this.variant ? "".concat(this.isDark ? 'bg' : 'table', "-").concat(this.variant) : null];
    },
    trAttrs: function trAttrs() {
      return _objectSpread({
        role: 'row'
      }, this.$attrs);
    }
  },
  render: function render(h) {
    return h('tr', {
      class: this.trClasses,
      attrs: this.trAttrs,
      // Pass native listeners to child
      on: this.$listeners
    }, this.normalizeSlot('default', {}));
  }
});

/***/ }),
/* 48 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export props */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTd; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_to_string__ = __webpack_require__(76);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__mixins_normalize_slot__ = __webpack_require__(46);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }





var digitsRx = /^\d+$/; // Parse a rowspan or colspan into a digit (or null if < 1 or NaN)

var parseSpan = function parseSpan(val) {
  val = parseInt(val, 10);
  return digitsRx.test(String(val)) && val > 0 ? val : null;
};
/* istanbul ignore next */


var spanValidator = function spanValidator(val) {
  return Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["m" /* isUndefinedOrNull */])(val) || parseSpan(val) > 0;
};

var props = {
  variant: {
    type: String,
    default: null
  },
  colspan: {
    type: [Number, String],
    default: null,
    validator: spanValidator
  },
  rowspan: {
    type: [Number, String],
    default: null,
    validator: spanValidator
  },
  stackedHeading: {
    type: String,
    default: null
  },
  stickyColumn: {
    type: Boolean,
    default: false
  }
}; // @vue/component

var BTd =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTableCell',
  mixins: [__WEBPACK_IMPORTED_MODULE_3__mixins_normalize_slot__["a" /* default */]],
  inheritAttrs: false,
  inject: {
    bvTableTr: {
      default: function _default()
      /* istanbul ignore next */
      {
        return {};
      }
    }
  },
  props: props,
  computed: {
    tag: function tag() {
      // Overridden by <b-th>
      return 'td';
    },
    inTbody: function inTbody() {
      return this.bvTableTr.inTbody;
    },
    inThead: function inThead() {
      return this.bvTableTr.inThead;
    },
    inTfoot: function inTfoot() {
      return this.bvTableTr.inTfoot;
    },
    isDark: function isDark() {
      return this.bvTableTr.isDark;
    },
    isStacked: function isStacked() {
      return this.bvTableTr.isStacked;
    },
    isStackedCell: function isStackedCell() {
      // We only support stacked-heading in tbody in stacked mode
      return this.inTbody && this.isStacked;
    },
    isResponsive: function isResponsive() {
      return this.bvTableTr.isResponsive;
    },
    isStickyHeader: function isStickyHeader() {
      // Needed to handle header background classes, due to lack of
      // background color inheritance with Bootstrap v4 table CSS
      // Sticky headers only apply to cells in table `thead`
      return this.bvTableTr.isStickyHeader;
    },
    isStickyColumn: function isStickyColumn() {
      // Needed to handle header background classes, due to lack of
      // background color inheritance with Bootstrap v4 table CSS
      // Sticky column cells are only available in responsive
      // mode (horizontal scrolling) or when sticky header mode
      // Applies to cells in `thead`, `tbody` and `tfoot`
      return !this.isStacked && (this.isResponsive || this.isStickyHeader) && this.stickyColumn;
    },
    rowVariant: function rowVariant() {
      return this.bvTableTr.variant;
    },
    headVariant: function headVariant() {
      return this.bvTableTr.headVariant;
    },
    footVariant: function footVariant()
    /* istanbul ignore next: need to add in tests for footer variant */
    {
      return this.bvTableTr.footVariant;
    },
    tableVariant: function tableVariant() {
      return this.bvTableTr.tableVariant;
    },
    computedColspan: function computedColspan() {
      return parseSpan(this.colspan);
    },
    computedRowspan: function computedRowspan() {
      return parseSpan(this.rowspan);
    },
    cellClasses: function cellClasses() {
      // We use computed props here for improved performance by caching
      // the results of the string interpolation
      // TODO: need to add handling for footVariant
      var variant = this.variant;

      if (!variant && this.isStickyHeader && !this.headVariant || !variant && this.isStickyColumn) {
        // Needed for sticky-header mode as Bootstrap v4 table cells do
        // not inherit parent's background-color. Boo!
        variant = this.rowVariant || this.tableVariant || 'b-table-default';
      }

      return [variant ? "".concat(this.isDark ? 'bg' : 'table', "-").concat(variant) : null, this.isStickyColumn ? 'b-table-sticky-column' : null];
    },
    cellAttrs: function cellAttrs() {
      // We use computed props here for improved performance by caching
      // the results of the object spread (Object.assign)
      var headOrFoot = this.inThead || this.inTfoot; // Make sure col/rowspan's are > 0 or null

      var colspan = this.computedColspan;
      var rowspan = this.computedRowspan; // Default role and scope

      var role = 'cell';
      var scope = null; // Compute role and scope
      // We only add scopes with an explicit span of 1 or greater

      if (headOrFoot) {
        // Header or footer cells
        role = 'columnheader';
        scope = colspan > 0 ? 'colspan' : 'col';
      } else if (this.tag === 'th') {
        // th's in tbody
        role = 'rowheader';
        scope = rowspan > 0 ? 'rowgroup' : 'row';
      }

      return _objectSpread({
        colspan: colspan,
        rowspan: rowspan,
        role: role,
        scope: scope
      }, this.$attrs, {
        // Add in the stacked cell label data-attribute if in
        // stacked mode (if a stacked heading label is provided)
        'data-label': this.isStackedCell && !Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["m" /* isUndefinedOrNull */])(this.stackedHeading) ? Object(__WEBPACK_IMPORTED_MODULE_1__utils_to_string__["a" /* default */])(this.stackedHeading) : null
      });
    }
  },
  render: function render(h) {
    var content = [this.normalizeSlot('default')];
    return h(this.tag, {
      class: this.cellClasses,
      attrs: this.cellAttrs,
      // Transfer any native listeners
      on: this.$listeners
    }, [this.isStackedCell ? h('div', [content]) : content]);
  }
});

/***/ }),
/* 49 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return hasWindowSupport; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return hasDocumentSupport; });
/* unused harmony export hasNavigatorSupport */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return hasPromiseSupport; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return hasMutationObserverSupport; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return isBrowser; });
/* unused harmony export userAgent */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return isJSDOM; });
/* unused harmony export isIE */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return hasPassiveEventSupport; });
/* unused harmony export hasTouchSupport */
/* unused harmony export hasPointerEventSupport */
/* unused harmony export hasIntersectionObserverSupport */
/* unused harmony export getEnv */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return getNoWarn; });
/**
 * Utilities to get information about the current environment
 */
// --- Constants ---
var hasWindowSupport = typeof window !== 'undefined';
var hasDocumentSupport = typeof document !== 'undefined';
var hasNavigatorSupport = typeof navigator !== 'undefined';
var hasPromiseSupport = typeof Promise !== 'undefined';
var hasMutationObserverSupport = typeof MutationObserver !== 'undefined' || typeof WebKitMutationObserver !== 'undefined' || typeof MozMutationObserver !== 'undefined';
var isBrowser = hasWindowSupport && hasDocumentSupport && hasNavigatorSupport; // Browser type sniffing

var userAgent = isBrowser ? window.navigator.userAgent.toLowerCase() : '';
var isJSDOM = userAgent.indexOf('jsdom') > 0;
var isIE = /msie|trident/.test(userAgent); // Determine if the browser supports the option passive for events

var hasPassiveEventSupport = function () {
  var passiveEventSupported = false;

  if (isBrowser) {
    try {
      var options = {
        get passive() {
          // This function will be called when the browser
          // attempts to access the passive property.

          /* istanbul ignore next: will never be called in JSDOM */
          passiveEventSupported = true;
        }

      };
      window.addEventListener('test', options, options);
      window.removeEventListener('test', options, options);
    } catch (err) {
      /* istanbul ignore next: will never be called in JSDOM */
      passiveEventSupported = false;
    }
  }

  return passiveEventSupported;
}();
var hasTouchSupport = isBrowser && ('ontouchstart' in document.documentElement || navigator.maxTouchPoints > 0);
var hasPointerEventSupport = isBrowser && Boolean(window.PointerEvent || window.MSPointerEvent);
var hasIntersectionObserverSupport = isBrowser && 'IntersectionObserver' in window && 'IntersectionObserverEntry' in window && // Edge 15 and UC Browser lack support for `isIntersecting`
// but we an use intersectionRatio > 0 instead
// 'isIntersecting' in window.IntersectionObserverEntry.prototype &&
'intersectionRatio' in window.IntersectionObserverEntry.prototype; // --- Getters ---

var getEnv = function getEnv(key) {
  var fallback = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var env = typeof process !== 'undefined' && process ? Object({"MIX_PUSHER_APP_CLUSTER":"mt1","MIX_PUSHER_APP_KEY":"","NODE_ENV":"development"}) || {} : {};

  if (!key) {
    /* istanbul ignore next */
    return env;
  }

  return env[key] || fallback;
};
var getNoWarn = function getNoWarn() {
  return getEnv('BOOTSTRAP_VUE_NO_WARN');
};
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(4)))

/***/ }),
/* 50 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__object__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__inspect__ = __webpack_require__(42);

 // Assumes both a and b are arrays!
// Handles when arrays are "sparse" (array.every(...) doesn't handle sparse)

var compareArrays = function compareArrays(a, b) {
  if (a.length !== b.length) {
    return false;
  }

  var equal = true;

  for (var i = 0; equal && i < a.length; i++) {
    equal = looseEqual(a[i], b[i]);
  }

  return equal;
};
/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 * Returns boolean true or false
 */


var looseEqual = function looseEqual(a, b) {
  if (a === b) {
    return true;
  }

  var aValidType = Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["c" /* isDate */])(a);
  var bValidType = Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["c" /* isDate */])(b);

  if (aValidType || bValidType) {
    return aValidType && bValidType ? a.getTime() === b.getTime() : false;
  }

  aValidType = Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["a" /* isArray */])(a);
  bValidType = Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["a" /* isArray */])(b);

  if (aValidType || bValidType) {
    return aValidType && bValidType ? compareArrays(a, b) : false;
  }

  aValidType = Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["g" /* isObject */])(a);
  bValidType = Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["g" /* isObject */])(b);

  if (aValidType || bValidType) {
    /* istanbul ignore if: this if will probably never be called */
    if (!aValidType || !bValidType) {
      return false;
    }

    var aKeysCount = Object(__WEBPACK_IMPORTED_MODULE_0__object__["g" /* keys */])(a).length;
    var bKeysCount = Object(__WEBPACK_IMPORTED_MODULE_0__object__["g" /* keys */])(b).length;

    if (aKeysCount !== bKeysCount) {
      return false;
    }

    for (var key in a) {
      // eslint-disable-next-line no-prototype-builtins
      var aHasKey = a.hasOwnProperty(key); // eslint-disable-next-line no-prototype-builtins

      var bHasKey = b.hasOwnProperty(key);

      if (aHasKey && !bHasKey || !aHasKey && bHasKey || !looseEqual(a[key], b[key])) {
        return false;
      }
    }
  }

  return String(a) === String(b);
};

/* harmony default export */ __webpack_exports__["a"] = (looseEqual);

/***/ }),
/* 51 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__inspect__ = __webpack_require__(42);

/**
 * Get property defined by dot/array notation in string.
 *
 * @link https://gist.github.com/jeneg/9767afdcca45601ea44930ea03e0febf#gistcomment-1935901
 *
 * @param {Object} obj
 * @param {string|Array} path
 * @param {*} defaultValue (optional)
 * @return {*}
 */

var get = function get(obj, path) {
  var defaultValue = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  // Handle array of path values
  path = Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["a" /* isArray */])(path) ? path.join('.') : path; // If no path or no object passed

  if (!path || !Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["g" /* isObject */])(obj)) {
    return defaultValue;
  } // Handle edge case where user has dot(s) in top-level item field key
  // See https://github.com/bootstrap-vue/bootstrap-vue/issues/2762
  // Switched to `in` operator vs `hasOwnProperty` to handle obj.prototype getters
  // https://github.com/bootstrap-vue/bootstrap-vue/issues/3463


  if (path in obj) {
    return obj[path];
  } // Handle string array notation (numeric indices only)


  path = String(path).replace(/\[(\d+)]/g, '.$1');
  var steps = path.split('.').filter(Boolean); // Handle case where someone passes a string of only dots

  if (steps.length === 0) {
    return defaultValue;
  } // Traverse path in object to find result
  // We use `!=` vs `!==` to test for both `null` and `undefined`
  // Switched to `in` operator vs `hasOwnProperty` to handle obj.prototype getters
  // https://github.com/bootstrap-vue/bootstrap-vue/issues/3463


  return steps.every(function (step) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["g" /* isObject */])(obj) && step in obj && (obj = obj[step]) != null;
  }) ? obj : defaultValue;
};

/* harmony default export */ __webpack_exports__["a"] = (get);

/***/ }),
/* 52 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/*
 * SSR Safe Client Side ID attribute generation
 * id's can only be generated client side, after mount.
 * this._uid is not synched between server and client.
 */
// @vue/component
/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    id: {
      type: String,
      default: null
    }
  },
  data: function data() {
    return {
      localId_: null
    };
  },
  computed: {
    safeId: function safeId() {
      // Computed property that returns a dynamic function for creating the ID.
      // Reacts to changes in both .id and .localId_ And regens a new function
      var id = this.id || this.localId_; // We return a function that accepts an optional suffix string
      // So this computed prop looks and works like a method!!!
      // But benefits from Vue's Computed prop caching

      var fn = function fn(suffix) {
        if (!id) {
          return null;
        }

        suffix = String(suffix || '').replace(/\s+/g, '_');
        return suffix ? id + '_' + suffix : id;
      };

      return fn;
    }
  },
  mounted: function mounted() {
    var _this = this;

    // mounted only occurs client side
    this.$nextTick(function () {
      // Update dom with auto ID after dom loaded to prevent
      // SSR hydration errors.
      _this.localId_ = "__BVID__".concat(_this._uid);
    });
  }
});

/***/ }),
/* 53 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * Converts a string, including strings in camelCase or snake_case, into Start Case (a variant
 * of Title Case where all words start with a capital letter), it keeps original single quote
 * and hyphen in the word.
 *
 * Copyright (c) 2017 Compass (MIT)
 * https://github.com/UrbanCompass/to-start-case
 * @author Zhuoyuan Zhang <https://github.com/drawyan>
 * @author Wei Wang <https://github.com/onlywei>
 *
 *
 *   'management_companies' to 'Management Companies'
 *   'managementCompanies' to 'Management Companies'
 *   `hell's kitchen` to `Hell's Kitchen`
 *   `co-op` to `Co-op`
 *
 * @param {String} str
 * @returns {String}
 */
var startCase = function startCase(str) {
  return str.replace(/_/g, ' ').replace(/([a-z])([A-Z])/g, function (str, $1, $2) {
    return $1 + ' ' + $2;
  }).replace(/(\s|^)(\w)/g, function (str, $1, $2) {
    return $1 + $2.toUpperCase();
  });
};

/* harmony default export */ __webpack_exports__["a"] = (startCase);

/***/ }),
/* 54 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return IGNORED_FIELD_KEYS; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return EVENT_FILTER; });
// Constants used by table helpers
// Object of item keys that should be ignored for headers and
// stringification and filter events
var IGNORED_FIELD_KEYS = {
  _rowVariant: true,
  _cellVariants: true,
  _showDetails: true
}; // Filter CSS selector for click/dblclick/etc. events
// If any of these selectors match the clicked element, we ignore the event

var EVENT_FILTER = ['a', 'a *', // Include content inside links
'button', 'button *', // Include content inside buttons
'input:not(.disabled):not([disabled])', 'select:not(.disabled):not([disabled])', 'textarea:not(.disabled):not([disabled])', '[role="link"]', '[role="link"] *', '[role="button"]', '[role="button"] *', '[tabindex]:not(.disabled):not([disabled])'].join(',');

/***/ }),
/* 55 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

// Mixin for providing stacked tables
/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    stacked: {
      type: [Boolean, String],
      default: false
    }
  },
  computed: {
    isStacked: function isStacked() {
      // `true` when always stacked, or returns breakpoint specified
      return this.stacked === '' ? true : this.stacked;
    },
    isStackedAlways: function isStackedAlways() {
      return this.isStacked === true;
    },
    stackedTableClasses: function stackedTableClasses() {
      return _defineProperty({
        'b-table-stacked': this.isStackedAlways
      }, "b-table-stacked-".concat(this.stacked), !this.isStackedAlways && this.isStacked);
    }
  }
});

/***/ }),
/* 56 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export cloneDeep */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__object__ = __webpack_require__(45);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }



var cloneDeep = function cloneDeep(obj) {
  var defaultValue = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : obj;

  if (Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["a" /* isArray */])(obj)) {
    return obj.reduce(function (result, val) {
      return [].concat(_toConsumableArray(result), [cloneDeep(val, val)]);
    }, []);
  }

  if (Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["h" /* isPlainObject */])(obj)) {
    return Object(__WEBPACK_IMPORTED_MODULE_1__object__["g" /* keys */])(obj).reduce(function (result, key) {
      return _objectSpread({}, result, _defineProperty({}, key, cloneDeep(obj[key], obj[key])));
    }, {});
  }

  return defaultValue;
};
/* harmony default export */ __webpack_exports__["a"] = (cloneDeep);

/***/ }),
/* 57 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export stripTags */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return htmlOrText; });
var stripTagsRegex = /(<([^>]+)>)/gi; // Removes any thing that looks like an HTML tag from the supplied string

var stripTags = function stripTags() {
  var text = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  return String(text).replace(stripTagsRegex, '');
}; // Generate a domProps object for either innerHTML, textContent or nothing

var htmlOrText = function htmlOrText(innerHTML, textContent) {
  return innerHTML ? {
    innerHTML: innerHTML
  } : textContent ? {
    textContent: textContent
  } : {};
};

/***/ }),
/* 58 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export getConfig */
/* unused harmony export getConfigValue */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return getComponentConfig; });
/* unused harmony export getBreakpoints */
/* unused harmony export getBreakpointsCached */
/* unused harmony export getBreakpointsUp */
/* unused harmony export getBreakpointsUpCached */
/* unused harmony export getBreakpointsDown */
/* unused harmony export getBreakpointsDownCached */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__clone_deep__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__get__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__memoize__ = __webpack_require__(90);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__config_defaults__ = __webpack_require__(72);




 // --- Constants ---

var PROP_NAME = '$bvConfig';
var VueProto = __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */].prototype; // --- Getter methods ---
// All methods return a deep clone (immutable) copy of the config
// value, to prevent mutation of the user config object.
// Get the current user config. For testing purposes only

var getConfig = function getConfig() {
  return VueProto[PROP_NAME] ? VueProto[PROP_NAME].getConfig() : {};
}; // Method to grab a config value based on a dotted/array notation key

var getConfigValue = function getConfigValue(key) {
  return VueProto[PROP_NAME] ? VueProto[PROP_NAME].getConfigValue(key) : Object(__WEBPACK_IMPORTED_MODULE_1__clone_deep__["a" /* default */])(Object(__WEBPACK_IMPORTED_MODULE_2__get__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_4__config_defaults__["a" /* default */], key));
}; // Method to grab a config value for a particular component

var getComponentConfig = function getComponentConfig(cmpName) {
  var key = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  // Return the particular config value for key for if specified,
  // otherwise we return the full config (or an empty object if not found)
  return key ? getConfigValue("".concat(cmpName, ".").concat(key)) : getConfigValue(cmpName) || {};
}; // Convenience method for getting all breakpoint names

var getBreakpoints = function getBreakpoints() {
  return getConfigValue('breakpoints');
}; // Private function for caching / locking-in breakpoint names

var _getBreakpointsCached = Object(__WEBPACK_IMPORTED_MODULE_3__memoize__["a" /* default */])(function () {
  return getBreakpoints();
}); // Convenience method for getting all breakpoint names.
// Caches the results after first access.


var getBreakpointsCached = function getBreakpointsCached() {
  return Object(__WEBPACK_IMPORTED_MODULE_1__clone_deep__["a" /* default */])(_getBreakpointsCached());
}; // Convenience method for getting breakpoints with
// the smallest breakpoint set as ''.
// Useful for components that create breakpoint specific props.

var getBreakpointsUp = function getBreakpointsUp() {
  var breakpoints = getBreakpoints();
  breakpoints[0] = '';
  return breakpoints;
}; // Convenience method for getting breakpoints with
// the smallest breakpoint set as ''.
// Useful for components that create breakpoint specific props.
// Caches the results after first access.

var getBreakpointsUpCached = Object(__WEBPACK_IMPORTED_MODULE_3__memoize__["a" /* default */])(function () {
  var breakpoints = getBreakpointsCached();
  breakpoints[0] = '';
  return breakpoints;
}); // Convenience method for getting breakpoints with
// the largest breakpoint set as ''.
// Useful for components that create breakpoint specific props.

var getBreakpointsDown = function getBreakpointsDown() {
  var breakpoints = getBreakpoints();
  breakpoints[breakpoints.length - 1] = '';
  return breakpoints;
}; // Convenience method for getting breakpoints with
// the largest breakpoint set as ''.
// Useful for components that create breakpoint specific props.
// Caches the results after first access.

/* istanbul ignore next: we don't use this method anywhere, yet */

var getBreakpointsDownCached = function getBreakpointsDownCached()
/* istanbul ignore next */
{
  var breakpoints = getBreakpointsCached();
  breakpoints[breakpoints.length - 1] = '';
  return breakpoints;
};

/***/ }),
/* 59 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export matchesEl */
/* unused harmony export closestEl */
/* unused harmony export requestAF */
/* unused harmony export MutationObs */
/* unused harmony export parseEventOptions */
/* unused harmony export eventOn */
/* unused harmony export eventOff */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return isElement; });
/* unused harmony export isVisible */
/* unused harmony export isDisabled */
/* unused harmony export reflow */
/* unused harmony export selectAll */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return select; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return matches; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return closest; });
/* unused harmony export contains */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return getById; });
/* unused harmony export addClass */
/* unused harmony export removeClass */
/* unused harmony export hasClass */
/* unused harmony export setAttr */
/* unused harmony export removeAttr */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return getAttr; });
/* unused harmony export hasAttr */
/* unused harmony export getBCR */
/* unused harmony export getCS */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return getSel; });
/* unused harmony export offset */
/* unused harmony export position */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__env__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_inspect__ = __webpack_require__(42);


 // --- Constants ---

var w = __WEBPACK_IMPORTED_MODULE_1__env__["f" /* hasWindowSupport */] ? window : {};
var d = __WEBPACK_IMPORTED_MODULE_1__env__["b" /* hasDocumentSupport */] ? document : {};
var elProto = typeof Element !== 'undefined' ? Element.prototype : {}; // --- Normalization utils ---
// See: https://developer.mozilla.org/en-US/docs/Web/API/Element/matches#Polyfill

/* istanbul ignore next */

var matchesEl = elProto.matches || elProto.msMatchesSelector || elProto.webkitMatchesSelector; // See: https://developer.mozilla.org/en-US/docs/Web/API/Element/closest

/* istanbul ignore next */

var closestEl = elProto.closest || function (sel)
/* istanbul ignore next */
{
  var el = this;

  do {
    // Use our "patched" matches function
    if (matches(el, sel)) {
      return el;
    }

    el = el.parentElement || el.parentNode;
  } while (!Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["e" /* isNull */])(el) && el.nodeType === Node.ELEMENT_NODE);

  return null;
}; // `requestAnimationFrame()` convenience method

var requestAF = w.requestAnimationFrame || w.webkitRequestAnimationFrame || w.mozRequestAnimationFrame || w.msRequestAnimationFrame || w.oRequestAnimationFrame || // Fallback, but not a true polyfill
// Only needed for Opera Mini

/* istanbul ignore next */
function (cb) {
  return setTimeout(cb, 16);
};
var MutationObs = w.MutationObserver || w.WebKitMutationObserver || w.MozMutationObserver || null; // --- Utils ---
// Normalize event options based on support of passive option
// Exported only for testing purposes

var parseEventOptions = function parseEventOptions(options) {
  /* istanbul ignore else: can't test in JSDOM, as it supports passive */
  if (__WEBPACK_IMPORTED_MODULE_1__env__["d" /* hasPassiveEventSupport */]) {
    return Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["g" /* isObject */])(options) ? options : {
      useCapture: Boolean(options || false)
    };
  } else {
    // Need to translate to actual Boolean value
    return Boolean(Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["g" /* isObject */])(options) ? options.useCapture : options);
  }
}; // Attach an event listener to an element

var eventOn = function eventOn(el, evtName, handler, options) {
  if (el && el.addEventListener) {
    el.addEventListener(evtName, handler, parseEventOptions(options));
  }
}; // Remove an event listener from an element

var eventOff = function eventOff(el, evtName, handler, options) {
  if (el && el.removeEventListener) {
    el.removeEventListener(evtName, handler, parseEventOptions(options));
  }
}; // Determine if an element is an HTML Element

var isElement = function isElement(el) {
  return Boolean(el && el.nodeType === Node.ELEMENT_NODE);
}; // Determine if an HTML element is visible - Faster than CSS check

var isVisible = function isVisible(el) {
  if (!isElement(el) || !contains(d.body, el)) {
    return false;
  }

  if (el.style.display === 'none') {
    // We do this check to help with vue-test-utils when using v-show

    /* istanbul ignore next */
    return false;
  } // All browsers support getBoundingClientRect(), except JSDOM as it returns all 0's for values :(
  // So any tests that need isVisible will fail in JSDOM
  // Except when we override the getBCR prototype in some tests


  var bcr = getBCR(el);
  return Boolean(bcr && bcr.height > 0 && bcr.width > 0);
}; // Determine if an element is disabled

var isDisabled = function isDisabled(el) {
  return !isElement(el) || el.disabled || Boolean(getAttr(el, 'disabled')) || hasClass(el, 'disabled');
}; // Cause/wait-for an element to reflow it's content (adjusting it's height/width)

var reflow = function reflow(el) {
  // Requesting an elements offsetHight will trigger a reflow of the element content

  /* istanbul ignore next: reflow doesn't happen in JSDOM */
  return isElement(el) && el.offsetHeight;
}; // Select all elements matching selector. Returns `[]` if none found

var selectAll = function selectAll(selector, root) {
  return Object(__WEBPACK_IMPORTED_MODULE_0__array__["c" /* from */])((isElement(root) ? root : d).querySelectorAll(selector));
}; // Select a single element, returns `null` if not found

var select = function select(selector, root) {
  return (isElement(root) ? root : d).querySelector(selector) || null;
}; // Determine if an element matches a selector

var matches = function matches(el, selector) {
  if (!isElement(el)) {
    return false;
  }

  return matchesEl.call(el, selector);
}; // Finds closest element matching selector. Returns `null` if not found

var closest = function closest(selector, root) {
  var includeRoot = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

  if (!isElement(root)) {
    return null;
  }

  var el = closestEl.call(root, selector); // Native closest behaviour when `includeRoot` is truthy,
  // else emulate jQuery closest and return `null` if match is
  // the passed in root element when `includeRoot` is falsey

  return includeRoot ? el : el === root ? null : el;
}; // Returns true if the parent element contains the child element

var contains = function contains(parent, child) {
  if (!parent || !Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(parent.contains)) {
    return false;
  }

  return parent.contains(child);
}; // Get an element given an ID

var getById = function getById(id) {
  return d.getElementById(/^#/.test(id) ? id.slice(1) : id) || null;
}; // Add a class to an element

var addClass = function addClass(el, className) {
  // We are checking for `el.classList` existence here since IE 11
  // returns `undefined` for some elements (e.g. SVG elements)
  // See https://github.com/bootstrap-vue/bootstrap-vue/issues/2713
  if (className && isElement(el) && el.classList) {
    el.classList.add(className);
  }
}; // Remove a class from an element

var removeClass = function removeClass(el, className) {
  // We are checking for `el.classList` existence here since IE 11
  // returns `undefined` for some elements (e.g. SVG elements)
  // See https://github.com/bootstrap-vue/bootstrap-vue/issues/2713
  if (className && isElement(el) && el.classList) {
    el.classList.remove(className);
  }
}; // Test if an element has a class

var hasClass = function hasClass(el, className) {
  // We are checking for `el.classList` existence here since IE 11
  // returns `undefined` for some elements (e.g. SVG elements)
  // See https://github.com/bootstrap-vue/bootstrap-vue/issues/2713
  if (className && isElement(el) && el.classList) {
    return el.classList.contains(className);
  }

  return false;
}; // Set an attribute on an element

var setAttr = function setAttr(el, attr, val) {
  if (attr && isElement(el)) {
    el.setAttribute(attr, val);
  }
}; // Remove an attribute from an element

var removeAttr = function removeAttr(el, attr) {
  if (attr && isElement(el)) {
    el.removeAttribute(attr);
  }
}; // Get an attribute value from an element
// Returns `null` if not found

var getAttr = function getAttr(el, attr) {
  return attr && isElement(el) ? el.getAttribute(attr) : null;
}; // Determine if an attribute exists on an element
// Returns `true` or `false`, or `null` if element not found

var hasAttr = function hasAttr(el, attr) {
  return attr && isElement(el) ? el.hasAttribute(attr) : null;
}; // Return the Bounding Client Rect of an element
// Returns `null` if not an element

/* istanbul ignore next: getBoundingClientRect() doesn't work in JSDOM */

var getBCR = function getBCR(el) {
  return isElement(el) ? el.getBoundingClientRect() : null;
}; // Get computed style object for an element

/* istanbul ignore next: getComputedStyle() doesn't work in JSDOM */

var getCS = function getCS(el) {
  return __WEBPACK_IMPORTED_MODULE_1__env__["f" /* hasWindowSupport */] && isElement(el) ? w.getComputedStyle(el) : {};
}; // Returns a `Selection` object representing the range of text selected
// Returns `null` if no window support is given

/* istanbul ignore next: getSelection() doesn't work in JSDOM */

var getSel = function getSel() {
  return __WEBPACK_IMPORTED_MODULE_1__env__["f" /* hasWindowSupport */] && w.getSelection ? w.getSelection() : null;
}; // Return an element's offset with respect to document element
// https://j11y.io/jquery/#v=git&fn=jQuery.fn.offset

var offset = function offset(el)
/* istanbul ignore next: getBoundingClientRect(), getClientRects() doesn't work in JSDOM */
{
  var _offset = {
    top: 0,
    left: 0
  };

  if (!isElement(el) || el.getClientRects().length === 0) {
    return _offset;
  }

  var bcr = getBCR(el);

  if (bcr) {
    var win = el.ownerDocument.defaultView;
    _offset.top = bcr.top + win.pageYOffset;
    _offset.left = bcr.left + win.pageXOffset;
  }

  return _offset;
}; // Return an element's offset with respect to to it's offsetParent
// https://j11y.io/jquery/#v=git&fn=jQuery.fn.position

var position = function position(el)
/* istanbul ignore next: getBoundingClientRect() doesn't work in JSDOM */
{
  var _offset = {
    top: 0,
    left: 0
  };

  if (!isElement(el)) {
    return _offset;
  }

  var parentOffset = {
    top: 0,
    left: 0
  };
  var elStyles = getCS(el);

  if (elStyles.position === 'fixed') {
    _offset = getBCR(el) || _offset;
  } else {
    _offset = offset(el);
    var doc = el.ownerDocument;
    var offsetParent = el.offsetParent || doc.documentElement;

    while (offsetParent && (offsetParent === doc.body || offsetParent === doc.documentElement) && getCS(offsetParent).position === 'static') {
      offsetParent = offsetParent.parentNode;
    }

    if (offsetParent && offsetParent !== el && offsetParent.nodeType === Node.ELEMENT_NODE) {
      parentOffset = offset(offsetParent);
      var offsetParentStyles = getCS(offsetParent);
      parentOffset.top += parseFloat(offsetParentStyles.borderTopWidth);
      parentOffset.left += parseFloat(offsetParentStyles.borderLeftWidth);
    }
  }

  return {
    top: _offset.top - parentOffset.top - parseFloat(elStyles.marginTop),
    left: _offset.left - parentOffset.left - parseFloat(elStyles.marginLeft)
  };
};

/***/ }),
/* 60 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export props */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTfoot; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__ = __webpack_require__(46);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



var props = {
  footVariant: {
    type: String,
    // supported values: 'lite', 'dark', or null
    default: null
  }
}; // @vue/component

var BTfoot =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTfoot',
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__["a" /* default */]],
  inheritAttrs: false,
  provide: function provide() {
    return {
      bvTableRowGroup: this
    };
  },
  inject: {
    bvTable: {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      default: function _default()
      /* istanbul ignore next */
      {
        return {};
      }
    }
  },
  props: props,
  computed: {
    isTfoot: function isTfoot() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return true;
    },
    isDark: function isDark()
    /* istanbul ignore next: Not currently sniffed in tests */
    {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.dark;
    },
    isStacked: function isStacked() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.isStacked;
    },
    isResponsive: function isResponsive() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.isResponsive;
    },
    isStickyHeader: function isStickyHeader() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      // Sticky headers are only supported in thead
      return false;
    },
    tableVariant: function tableVariant()
    /* istanbul ignore next: Not currently sniffed in tests */
    {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.tableVariant;
    },
    tfootClasses: function tfootClasses() {
      return [this.footVariant ? "thead-".concat(this.footVariant) : null];
    },
    tfootAttrs: function tfootAttrs() {
      return _objectSpread({
        role: 'rowgroup'
      }, this.$attrs);
    }
  },
  render: function render(h) {
    return h('tfoot', {
      class: this.tfootClasses,
      attrs: this.tfootAttrs,
      // Pass down any native listeners
      on: this.$listeners
    }, this.normalizeSlot('default', {}));
  }
});

/***/ }),
/* 61 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTh; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__td__ = __webpack_require__(48);

 // @vue/component

var BTh =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTh',
  extends: __WEBPACK_IMPORTED_MODULE_1__td__["a" /* BTd */],
  computed: {
    tag: function tag() {
      return 'th';
    }
  }
});

/***/ }),
/* 62 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export warn */
/* unused harmony export warnNotClient */
/* unused harmony export warnNoPromiseSupport */
/* unused harmony export warnNoMutationObserverSupport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__env__ = __webpack_require__(49);

/**
 * Log a warning message to the console with BootstrapVue formatting
 * @param {string} message
 */

var warn = function warn(message)
/* istanbul ignore next */
{
  if (!Object(__WEBPACK_IMPORTED_MODULE_0__env__["a" /* getNoWarn */])()) {
    console.warn("[BootstrapVue warn]: ".concat(message));
  }
};
/**
 * Warn when no Promise support is given
 * @param {string} source
 * @returns {boolean} warned
 */

var warnNotClient = function warnNotClient(source) {
  /* istanbul ignore else */
  if (__WEBPACK_IMPORTED_MODULE_0__env__["g" /* isBrowser */]) {
    return false;
  } else {
    warn("".concat(source, ": Can not be called during SSR."));
    return true;
  }
};
/**
 * Warn when no Promise support is given
 * @param {string} source
 * @returns {boolean} warned
 */

var warnNoPromiseSupport = function warnNoPromiseSupport(source) {
  /* istanbul ignore else */
  if (__WEBPACK_IMPORTED_MODULE_0__env__["e" /* hasPromiseSupport */]) {
    return false;
  } else {
    warn("".concat(source, ": Requires Promise support."));
    return true;
  }
};
/**
 * Warn when no MutationObserver support is given
 * @param {string} source
 * @returns {boolean} warned
 */

var warnNoMutationObserverSupport = function warnNoMutationObserverSupport(source) {
  /* istanbul ignore else */
  if (__WEBPACK_IMPORTED_MODULE_0__env__["c" /* hasMutationObserverSupport */]) {
    return false;
  } else {
    warn("".concat(source, ": Requires MutationObserver support."));
    return true;
  }
}; // Default export

/* harmony default export */ __webpack_exports__["a"] = (warn);

/***/ }),
/* 63 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_inspect__ = __webpack_require__(42);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

 // Main `<table>` render mixin
// Includes all main table styling options

/* harmony default export */ __webpack_exports__["a"] = ({
  // Don't place attributes on root element automatically,
  // as table could be wrapped in responsive `<div>`
  inheritAttrs: false,
  provide: function provide() {
    return {
      bvTable: this
    };
  },
  props: {
    striped: {
      type: Boolean,
      default: false
    },
    bordered: {
      type: Boolean,
      default: false
    },
    borderless: {
      type: Boolean,
      default: false
    },
    outlined: {
      type: Boolean,
      default: false
    },
    dark: {
      type: Boolean,
      default: false
    },
    hover: {
      type: Boolean,
      default: false
    },
    small: {
      type: Boolean,
      default: false
    },
    fixed: {
      type: Boolean,
      default: false
    },
    responsive: {
      type: [Boolean, String],
      default: false
    },
    stickyHeader: {
      // If a string, it is assumed to be the table `max-height` value
      type: [Boolean, String],
      default: false
    },
    noBorderCollapse: {
      type: Boolean,
      default: false
    },
    captionTop: {
      type: Boolean,
      default: false
    },
    tableVariant: {
      type: String,
      default: null
    },
    tableClass: {
      type: [String, Array, Object],
      default: null
    }
  },
  computed: {
    // Layout related computed props
    isResponsive: function isResponsive() {
      var responsive = this.responsive === '' ? true : this.responsive;
      return this.isStacked ? false : responsive;
    },
    isStickyHeader: function isStickyHeader() {
      var stickyHeader = this.stickyHeader === '' ? true : this.stickyHeader;
      return this.isStacked ? false : stickyHeader;
    },
    wrapperClasses: function wrapperClasses() {
      return [this.isStickyHeader ? 'b-table-sticky-header' : '', this.isResponsive === true ? 'table-responsive' : this.isResponsive ? "table-responsive-".concat(this.responsive) : ''].filter(Boolean);
    },
    wrapperStyles: function wrapperStyles() {
      return this.isStickyHeader && !Object(__WEBPACK_IMPORTED_MODULE_0__utils_inspect__["b" /* isBoolean */])(this.isStickyHeader) ? {
        maxHeight: this.isStickyHeader
      } : {};
    },
    tableClasses: function tableClasses() {
      var hover = this.isTableSimple ? this.hover : this.hover && this.computedItems.length > 0 && !this.computedBusy;
      return [// User supplied classes
      this.tableClass, // Styling classes
      {
        'table-striped': this.striped,
        'table-hover': hover,
        'table-dark': this.dark,
        'table-bordered': this.bordered,
        'table-borderless': this.borderless,
        'table-sm': this.small,
        // The following are b-table custom styles
        border: this.outlined,
        'b-table-fixed': this.fixed,
        'b-table-caption-top': this.captionTop,
        'b-table-no-border-collapse': this.noBorderCollapse
      }, this.tableVariant ? "".concat(this.dark ? 'bg' : 'table', "-").concat(this.tableVariant) : '', // Stacked table classes
      this.stackedTableClasses, // Selectable classes
      this.selectableTableClasses];
    },
    tableAttrs: function tableAttrs() {
      // Preserve user supplied aria-describedby, if provided in `$attrs`
      var adb = [(this.$attrs || {})['aria-describedby'], this.captionId].filter(Boolean).join(' ') || null;
      var items = this.computedItems;
      var filteredItems = this.filteredItems;
      var fields = this.computedFields;
      var selectableAttrs = this.selectableTableAttrs || {};
      var ariaAttrs = this.isTableSimple ? {} : {
        'aria-busy': this.computedBusy ? 'true' : 'false',
        'aria-colcount': String(fields.length),
        'aria-describedby': adb
      };
      var rowCount = items && filteredItems && filteredItems.length > items.length ? String(filteredItems.length) : null;
      return _objectSpread({
        // We set `aria-rowcount` before merging in `$attrs`,
        // in case user has supplied their own
        'aria-rowcount': rowCount
      }, this.$attrs, {
        // Now we can override any `$attrs` here
        id: this.safeId(),
        role: 'table'
      }, ariaAttrs, {}, selectableAttrs);
    }
  },
  render: function render(h) {
    var $content = [];

    if (this.isTableSimple) {
      $content.push(this.normalizeSlot('default', {}));
    } else {
      // Build the `<caption>` (from caption mixin)
      $content.push(this.renderCaption ? this.renderCaption() : null); // Build the `<colgroup>`

      $content.push(this.renderColgroup ? this.renderColgroup() : null); // Build the `<thead>`

      $content.push(this.renderThead ? this.renderThead() : null); // Build the `<tbody>`

      $content.push(this.renderTbody ? this.renderTbody() : null); // Build the `<tfoot>`

      $content.push(this.renderTfoot ? this.renderTfoot() : null);
    } // Assemble `<table>`


    var $table = h('table', {
      key: 'b-table',
      staticClass: 'table b-table',
      class: this.tableClasses,
      attrs: this.tableAttrs
    }, $content.filter(Boolean)); // Add responsive/sticky wrapper if needed and return table

    return this.wrapperClasses.length > 0 ? h('div', {
      key: 'wrap',
      class: this.wrapperClasses,
      style: this.wrapperStyles
    }, [$table]) : $table;
  }
});

/***/ }),
/* 64 */,
/* 65 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__normalize_fields__ = __webpack_require__(83);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    items: {
      // Provider mixin adds in `Function` type
      type: Array,
      default: function _default()
      /* istanbul ignore next */
      {
        return [];
      }
    },
    fields: {
      type: Array,
      default: null
    },
    primaryKey: {
      // Primary key for record
      // If provided the value in each row must be unique!
      type: String,
      default: null
    },
    value: {
      // `v-model` for retrieving the current displayed rows
      type: Array,
      default: function _default() {
        return [];
      }
    }
  },
  data: function data() {
    return {
      // Our local copy of the items
      // Must be an array
      localItems: Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["a" /* isArray */])(this.items) ? this.items.slice() : []
    };
  },
  computed: {
    computedFields: function computedFields() {
      // We normalize fields into an array of objects
      // `[ { key:..., label:..., ...}, {...}, ..., {..}]`
      return Object(__WEBPACK_IMPORTED_MODULE_2__normalize_fields__["a" /* default */])(this.fields, this.localItems);
    },
    computedFieldsObj: function computedFieldsObj() {
      // Fields as a simple lookup hash object
      // Mainly for formatter lookup and use in `scopedSlots` for convenience
      // If the field has a formatter, it normalizes formatter to a
      // function ref or `undefined` if no formatter
      var parent = this.$parent;
      return this.computedFields.reduce(function (obj, f) {
        // We use object spread here so we don't mutate the original field object
        obj[f.key] = _objectSpread({}, f);

        if (f.formatter) {
          // Normalize formatter to a function ref or `undefined`
          var formatter = f.formatter;

          if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["k" /* isString */])(formatter) && Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["d" /* isFunction */])(parent[formatter])) {
            formatter = parent[formatter];
          } else if (!Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["d" /* isFunction */])(formatter)) {
            /* istanbul ignore next */
            formatter = undefined;
          } // Return formatter function or `undefined` if none


          obj[f.key].formatter = formatter;
        }

        return obj;
      }, {});
    },
    computedItems: function computedItems() {
      // Fallback if various mixins not provided
      return (this.paginatedItems || this.sortedItems || this.filteredItems || this.localItems || []).slice();
    },
    context: function context() {
      // Current state of sorting, filtering and pagination props/values
      return {
        filter: this.localFilter,
        sortBy: this.localSortBy,
        sortDesc: this.localSortDesc,
        perPage: parseInt(this.perPage, 10) || 0,
        currentPage: parseInt(this.currentPage, 10) || 1,
        apiUrl: this.apiUrl
      };
    }
  },
  watch: {
    items: function items(newItems) {
      /* istanbul ignore else */
      if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["a" /* isArray */])(newItems)) {
        // Set `localItems`/`filteredItems` to a copy of the provided array
        this.localItems = newItems.slice();
      } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["l" /* isUndefined */])(newItems) || Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["e" /* isNull */])(newItems)) {
        /* istanbul ignore next */
        this.localItems = [];
      }
    },
    // Watch for changes on `computedItems` and update the `v-model`
    computedItems: function computedItems(newVal) {
      this.$emit('input', newVal);
    },
    // Watch for context changes
    context: function context(newVal, oldVal) {
      // Emit context information for external paging/filtering/sorting handling
      if (!Object(__WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__["a" /* default */])(newVal, oldVal)) {
        this.$emit('context-changed', newVal);
      }
    }
  },
  mounted: function mounted() {
    // Initially update the `v-model` of displayed items
    this.$emit('input', this.computedItems);
  },
  methods: {
    // Method to get the formatter method for a given field key
    getFieldFormatter: function getFieldFormatter(key) {
      var field = this.computedFieldsObj[key]; // `this.computedFieldsObj` has pre-normalized the formatter to a
      // function ref if present, otherwise `undefined`

      return field ? field.formatter : undefined;
    }
  }
});

/***/ }),
/* 66 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_object__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__constants__ = __webpack_require__(54);



 // Return a copy of a row after all reserved fields have been filtered out

var sanitizeRow = function sanitizeRow(row, ignoreFields, includeFields) {
  var fieldsObj = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {};
  return Object(__WEBPACK_IMPORTED_MODULE_0__utils_object__["g" /* keys */])(row).reduce(function (obj, key) {
    // Ignore special fields that start with `_`
    // Ignore fields in the `ignoreFields` array
    // Include only fields in the `includeFields` array
    if (!__WEBPACK_IMPORTED_MODULE_3__constants__["b" /* IGNORED_FIELD_KEYS */][key] && !(ignoreFields && ignoreFields.length > 0 && Object(__WEBPACK_IMPORTED_MODULE_1__utils_array__["a" /* arrayIncludes */])(ignoreFields, key)) && !(includeFields && includeFields.length > 0 && !Object(__WEBPACK_IMPORTED_MODULE_1__utils_array__["a" /* arrayIncludes */])(includeFields, key))) {
      var f = fieldsObj[key] || {};
      var val = row[key]; // `f.filterByFormatted` will either be a function or boolean
      // `f.formater` will have already been noramlized into a function ref

      var filterByFormatted = f.filterByFormatted;
      var formatter = Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(filterByFormatted) ? filterByFormatted : filterByFormatted ? f.formatter : null;
      obj[key] = Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(formatter) ? formatter(val, key, row) : val;
    }

    return obj;
  }, {});
};

/* harmony default export */ __webpack_exports__["a"] = (sanitizeRow);

/***/ }),
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_object__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_inspect__ = __webpack_require__(42);

 // Recursively stringifies the values of an object, space separated, in an
// SSR safe deterministic way (keys are sorted before stringification)
//
//   ex:
//     { b: 3, c: { z: 'zzz', d: null, e: 2 }, d: [10, 12, 11], a: 'one' }
//   becomes
//     'one 3 2 zzz 10 12 11'
//
// Primitives (numbers/strings) are returned as-is
// Null and undefined values are filtered out
// Dates are converted to their native string format

var stringifyObjectValues = function stringifyObjectValues(val) {
  if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["m" /* isUndefinedOrNull */])(val)) {
    /* istanbul ignore next */
    return '';
  } // Arrays are also object, and keys just returns the array indexes
  // Date objects we convert to strings


  if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["g" /* isObject */])(val) && !Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["c" /* isDate */])(val)) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_object__["g" /* keys */])(val).sort() // Sort to prevent SSR issues on pre-rendered sorted tables
    .filter(function (v) {
      return !Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["m" /* isUndefinedOrNull */])(v);
    }) // Ignore undefined/null values
    .map(function (k) {
      return stringifyObjectValues(val[k]);
    }).join(' ');
  }

  return String(val);
};

/* harmony default export */ __webpack_exports__["a"] = (stringifyObjectValues);

/***/ }),
/* 68 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_html__ = __webpack_require__(57);

/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    // `caption-top` is part of table-redere mixin (styling)
    // captionTop: {
    //   type: Boolean,
    //   default: false
    // },
    caption: {
      type: String,
      default: null
    },
    captionHtml: {
      type: String
    }
  },
  computed: {
    captionId: function captionId() {
      // Even though `this.safeId` looks like a method, it is a computed prop
      // that returns a new function if the underlying ID changes
      return this.isStacked ? this.safeId('_caption_') : null;
    }
  },
  methods: {
    renderCaption: function renderCaption() {
      var h = this.$createElement; // Build the caption

      var $captionSlot = this.normalizeSlot('table-caption');
      var $caption = h();

      if ($captionSlot || this.caption || this.captionHtml) {
        var data = {
          key: 'caption',
          attrs: {
            id: this.captionId
          }
        };

        if (!$captionSlot) {
          data.domProps = Object(__WEBPACK_IMPORTED_MODULE_0__utils_html__["a" /* htmlOrText */])(this.captionHtml, this.caption);
        }

        $caption = h('caption', data, [$captionSlot]);
      }

      return $caption;
    }
  }
});

/***/ }),
/* 69 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
  methods: {
    renderColgroup: function renderColgroup() {
      var h = this.$createElement;
      var fields = this.computedFields;
      var $colgroup = h();

      if (this.hasNormalizedSlot('table-colgroup')) {
        $colgroup = h('colgroup', {
          key: 'colgroup'
        }, [this.normalizeSlot('table-colgroup', {
          columns: fields.length,
          fields: fields
        })]);
      }

      return $colgroup;
    }
  }
});

/***/ }),
/* 70 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__ = __webpack_require__(71);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_startcase__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_config__ = __webpack_require__(58);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utils_html__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__filter_event__ = __webpack_require__(73);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__text_selection_active__ = __webpack_require__(74);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__thead__ = __webpack_require__(75);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__tfoot__ = __webpack_require__(60);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__tr__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__th__ = __webpack_require__(61);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }











/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    headVariant: {
      type: String,
      // 'light', 'dark' or null (or custom)
      default: function _default() {
        return Object(__WEBPACK_IMPORTED_MODULE_2__utils_config__["a" /* getComponentConfig */])('BTable', 'headVariant');
      }
    },
    theadClass: {
      type: [String, Array, Object] // default: undefined

    },
    theadTrClass: {
      type: [String, Array, Object] // default: undefined

    }
  },
  methods: {
    fieldClasses: function fieldClasses(field) {
      // Header field (<th>) classes
      return [field.class ? field.class : '', field.thClass ? field.thClass : ''];
    },
    headClicked: function headClicked(evt, field, isFoot) {
      if (this.stopIfBusy && this.stopIfBusy(evt)) {
        // If table is busy (via provider) then don't propagate
        return;
      } else if (Object(__WEBPACK_IMPORTED_MODULE_4__filter_event__["a" /* default */])(evt)) {
        // Clicked on a non-disabled control so ignore
        return;
      } else if (Object(__WEBPACK_IMPORTED_MODULE_5__text_selection_active__["a" /* default */])(this.$el)) {
        // User is selecting text, so ignore

        /* istanbul ignore next: JSDOM doesn't support getSelection() */
        return;
      }

      evt.stopPropagation();
      evt.preventDefault();
      this.$emit('head-clicked', field.key, field, evt, isFoot);
    },
    renderThead: function renderThead() {
      var _this = this;

      var isFoot = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var h = this.$createElement;
      var fields = this.computedFields || [];

      if (this.isStackedAlways || fields.length === 0) {
        // In always stacked mode, we don't bother rendering the head/foot.
        // Or if no field headings (empty table)
        return h();
      } // Refernce to `selectAllRows` and `clearSelected()`, if table is Selectable


      var selectAllRows = this.isSelectable ? this.selectAllRows : function () {};
      var clearSelected = this.isSelectable ? this.clearSelected : function () {}; // Helper function to generate a field <th> cell

      var makeCell = function makeCell(field, colIndex) {
        var ariaLabel = null;

        if (!field.label.trim() && !field.headerTitle) {
          // In case field's label and title are empty/blank
          // We need to add a hint about what the column is about for non-sighted users

          /* istanbul ignore next */
          ariaLabel = Object(__WEBPACK_IMPORTED_MODULE_1__utils_startcase__["a" /* default */])(field.key);
        }

        var hasHeadClickListener = _this.$listeners['head-clicked'] || _this.isSortable;
        var handlers = {};

        if (hasHeadClickListener) {
          handlers.click = function (evt) {
            _this.headClicked(evt, field, isFoot);
          };

          handlers.keydown = function (evt) {
            var keyCode = evt.keyCode;

            if (keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].ENTER || keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].SPACE) {
              _this.headClicked(evt, field, isFoot);
            }
          };
        }

        var sortAttrs = _this.isSortable ? _this.sortTheadThAttrs(field.key, field, isFoot) : {};
        var sortClass = _this.isSortable ? _this.sortTheadThClasses(field.key, field, isFoot) : null;
        var data = {
          key: field.key,
          class: [_this.fieldClasses(field), sortClass],
          props: {
            variant: field.variant,
            stickyColumn: field.stickyColumn
          },
          style: field.thStyle || {},
          attrs: _objectSpread({
            // We only add a tabindex of 0 if there is a head-clicked listener
            tabindex: hasHeadClickListener ? '0' : null,
            abbr: field.headerAbbr || null,
            title: field.headerTitle || null,
            'aria-colindex': String(colIndex + 1),
            'aria-label': ariaLabel
          }, _this.getThValues(null, field.key, field.thAttr, isFoot ? 'foot' : 'head', {}), {}, sortAttrs),
          on: handlers
        }; // Handle edge case where in-document templates are used with new
        // `v-slot:name` syntax where the browser lower-cases the v-slot's
        // name (attributes become lower cased when parsed by the browser)
        // We have replaced the square bracket syntax with round brackets
        // to prevent confusion with dynamic slot names

        var slotNames = ["head(".concat(field.key, ")"), "head(".concat(field.key.toLowerCase(), ")"), 'head()'];

        if (isFoot) {
          // Footer will fallback to header slot names
          slotNames = ["foot(".concat(field.key, ")"), "foot(".concat(field.key.toLowerCase(), ")"), 'foot()'].concat(_toConsumableArray(slotNames));
        }

        var hasSlot = _this.hasNormalizedSlot(slotNames);

        var slot = field.label;

        if (hasSlot) {
          slot = _this.normalizeSlot(slotNames, {
            label: field.label,
            column: field.key,
            field: field,
            isFoot: isFoot,
            // Add in row select methods
            selectAllRows: selectAllRows,
            clearSelected: clearSelected
          });
        } else {
          data.domProps = Object(__WEBPACK_IMPORTED_MODULE_3__utils_html__["a" /* htmlOrText */])(field.labelHtml);
        }

        return h(__WEBPACK_IMPORTED_MODULE_9__th__["a" /* BTh */], data, slot);
      }; // Generate the array of <th> cells


      var $cells = fields.map(makeCell).filter(function (th) {
        return th;
      }); // Genrate the row(s)

      var $trs = [];

      if (isFoot) {
        $trs.push(h(__WEBPACK_IMPORTED_MODULE_8__tr__["a" /* BTr */], {
          class: this.tfootTrClass
        }, $cells));
      } else {
        var scope = {
          columns: fields.length,
          fields: fields,
          // Add in row select methods
          selectAllRows: selectAllRows,
          clearSelected: clearSelected
        };
        $trs.push(this.normalizeSlot('thead-top', scope) || h());
        $trs.push(h(__WEBPACK_IMPORTED_MODULE_8__tr__["a" /* BTr */], {
          class: this.theadTrClass
        }, $cells));
      }

      return h(isFoot ? __WEBPACK_IMPORTED_MODULE_7__tfoot__["a" /* BTfoot */] : __WEBPACK_IMPORTED_MODULE_6__thead__["a" /* BThead */], {
        key: isFoot ? 'bv-tfoot' : 'bv-thead',
        class: (isFoot ? this.tfootClass : this.theadClass) || null,
        props: isFoot ? {
          footVariant: this.footVariant || this.headVariant || null
        } : {
          headVariant: this.headVariant || null
        }
      }, $trs);
    }
  }
});

/***/ }),
/* 71 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/*
 * Key Codes (events)
 */
var KEY_CODES = {
  SPACE: 32,
  ENTER: 13,
  ESC: 27,
  LEFT: 37,
  UP: 38,
  RIGHT: 39,
  DOWN: 40,
  PAGEUP: 33,
  PAGEDOWN: 34,
  HOME: 36,
  END: 35,
  TAB: 9,
  SHIFT: 16,
  CTRL: 17,
  BACKSPACE: 8,
  ALT: 18,
  PAUSE: 19,
  BREAK: 19,
  INSERT: 45,
  INS: 45,
  DELETE: 46
};
/* harmony default export */ __webpack_exports__["a"] = (KEY_CODES);

/***/ }),
/* 72 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__object__ = __webpack_require__(45);
 // --- General BootstrapVue configuration ---
// NOTES
//
// The global config SHALL NOT be used to set defaults for Boolean props, as the props
// would loose their semantic meaning, and force people writing 3rd party components to
// explicity set a true or false value using the v-bind syntax on boolean props
//
// Supported config values (depending on the prop's supported type(s)):
// `String`, `Array`, `Object`, `null` or `undefined`
// BREAKPOINT DEFINITIONS
//
// Some components (`<b-col>` and `<b-form-group>`) generate props based on breakpoints,
// and this occurs when the component is first loaded (evaluated), which may happen
// before the config is created/modified
//
// To get around this we make these components' props async (lazy evaluation)
// The component definition is only called/executed when the first access to the
// component is used (and cached on subsequent uses)
// PROP DEFAULTS
//
// For default values on props, we use the default value factory function approach so
// that the default values are pulled in at each component instantiation
//
//  props: {
//    variant: {
//      type: String,
//      default: () => getConfigComponent('BAlert', 'variant')
//    }
//  }
//
// We also provide a cached getter for breakpoints, which are "frozen" on first access
// prettier-ignore

/* harmony default export */ __webpack_exports__["a"] = (Object(__WEBPACK_IMPORTED_MODULE_0__object__["b" /* deepFreeze */])({
  // Breakpoints
  breakpoints: ['xs', 'sm', 'md', 'lg', 'xl'],
  // Form controls
  formControls: {
    size: null
  },
  // Component specific defaults are keyed by the component
  // name (PascalCase) and prop name (camelCase)
  BAlert: {
    dismissLabel: 'Close',
    variant: 'info'
  },
  BBadge: {
    variant: 'secondary'
  },
  BButton: {
    size: null,
    variant: 'secondary'
  },
  BButtonClose: {
    // `textVariant` is `null` to inherit the current text color
    textVariant: null,
    ariaLabel: 'Close'
  },
  BCardSubTitle: {
    // `<b-card>` and `<b-card-body>` also inherit this prop
    subTitleTextVariant: 'muted'
  },
  BCarousel: {
    labelPrev: 'Previous Slide',
    labelNext: 'Next Slide',
    labelGotoSlide: 'Goto Slide',
    labelIndicators: 'Select a slide to display'
  },
  BDropdown: {
    toggleText: 'Toggle Dropdown',
    size: null,
    variant: 'secondary',
    splitVariant: null
  },
  BFormFile: {
    browseText: 'Browse',
    // Chrome default file prompt
    placeholder: 'No file chosen',
    dropPlaceholder: 'Drop files here'
  },
  BFormText: {
    textVariant: 'muted'
  },
  BImg: {
    blankColor: 'transparent'
  },
  BImgLazy: {
    blankColor: 'transparent'
  },
  BInputGroup: {
    size: null
  },
  BJumbotron: {
    bgVariant: null,
    borderVariant: null,
    textVariant: null
  },
  BListGroupItem: {
    variant: null
  },
  BModal: {
    titleTag: 'h5',
    size: 'md',
    headerBgVariant: null,
    headerBorderVariant: null,
    headerTextVariant: null,
    headerCloseVariant: null,
    bodyBgVariant: null,
    bodyTextVariant: null,
    footerBgVariant: null,
    footerBorderVariant: null,
    footerTextVariant: null,
    cancelTitle: 'Cancel',
    cancelVariant: 'secondary',
    okTitle: 'OK',
    okVariant: 'primary',
    headerCloseLabel: 'Close'
  },
  BNavbar: {
    variant: null
  },
  BNavbarToggle: {
    label: 'Toggle navigation'
  },
  BPagination: {
    size: null
  },
  BPaginationNav: {
    size: null
  },
  BPopover: {
    boundary: 'scrollParent',
    boundaryPadding: 5,
    customClass: null,
    delay: 50,
    variant: null
  },
  BProgress: {
    variant: null
  },
  BProgressBar: {
    variant: null
  },
  BSpinner: {
    variant: null
  },
  BTable: {
    selectedVariant: 'primary',
    headVariant: null,
    footVariant: null
  },
  BToast: {
    toaster: 'b-toaster-top-right',
    autoHideDelay: 5000,
    variant: null,
    toastClass: null,
    headerClass: null,
    bodyClass: null
  },
  BToaster: {
    ariaLive: null,
    ariaAtomic: null,
    role: null
  },
  BTooltip: {
    boundary: 'scrollParent',
    boundaryPadding: 5,
    customClass: null,
    delay: 50,
    variant: null
  }
}));

/***/ }),
/* 73 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_dom__ = __webpack_require__(59);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__constants__ = __webpack_require__(54);


var TABLE_TAG_NAMES = ['TD', 'TH', 'TR']; // Returns `true` if we should ignore the click/double-click/keypress event
// Avoids having the user need to use `@click.stop` on the form control

var filterEvent = function filterEvent(evt) {
  // Exit early when we don't have a target element
  if (!evt || !evt.target) {
    /* istanbul ignore next */
    return false;
  }

  var el = evt.target; // Exit early when element is disabled or a table element

  if (el.disabled || TABLE_TAG_NAMES.indexOf(el.tagName) !== -1) {
    return false;
  } // Ignore the click when it was inside a dropdown menu


  if (Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["a" /* closest */])('.dropdown-menu', el)) {
    return true;
  }

  var label = el.tagName === 'LABEL' ? el : Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["a" /* closest */])('label', el); // If the label's form control is not disabled then we don't propagate event
  // Modern browsers have `label.control` that references the associated input, but IE11
  // does not have this property on the label element, so we resort to DOM lookups

  if (label) {
    var labelFor = Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["b" /* getAttr */])(label, 'for');
    var input = labelFor ? Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["c" /* getById */])(labelFor) : Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["g" /* select */])('input, select, textarea', label);

    if (input && !input.disabled) {
      return true;
    }
  } // Otherwise check if the event target matches one of the selectors in the
  // event filter (i.e. anchors, non disabled inputs, etc.)
  // Return `true` if we should ignore the event


  return Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["f" /* matches */])(el, __WEBPACK_IMPORTED_MODULE_1__constants__["a" /* EVENT_FILTER */]);
};

/* harmony default export */ __webpack_exports__["a"] = (filterEvent);

/***/ }),
/* 74 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_dom__ = __webpack_require__(59);
 // Helper to determine if a there is an active text selection on the document page
// Used to filter out click events caused by the mouse up at end of selection
//
// Accepts an element as only argument to test to see if selection overlaps or is
// contained within the element

var textSelectionActive = function textSelectionActive() {
  var el = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : document;
  var sel = Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["d" /* getSel */])();
  return sel && sel.toString().trim() !== '' && sel.containsNode && Object(__WEBPACK_IMPORTED_MODULE_0__utils_dom__["e" /* isElement */])(el) ? sel.containsNode(el, true) : false;
};

/* harmony default export */ __webpack_exports__["a"] = (textSelectionActive);

/***/ }),
/* 75 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export props */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BThead; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__ = __webpack_require__(46);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



var props = {
  headVariant: {
    // Also sniffed by <b-tr> / <b-td> / <b-th>
    type: String,
    // supported values: 'lite', 'dark', or null
    default: null
  }
}; // @vue/component

var BThead =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BThead',
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__["a" /* default */]],
  inheritAttrs: false,
  provide: function provide() {
    return {
      bvTableRowGroup: this
    };
  },
  inject: {
    bvTable: {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      default: function _default()
      /* istanbul ignore next */
      {
        return {};
      }
    }
  },
  props: props,
  computed: {
    isThead: function isThead() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return true;
    },
    isDark: function isDark() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.dark;
    },
    isStacked: function isStacked() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.isStacked;
    },
    isResponsive: function isResponsive() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.isResponsive;
    },
    isStickyHeader: function isStickyHeader() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      // Needed to handle header background classes, due to lack of
      // background color inheritance with Bootstrap v4 table CSS
      // Sticky headers only apply to cells in table `thead`
      return !this.isStacked && this.bvTable.stickyHeader;
    },
    tableVariant: function tableVariant() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.tableVariant;
    },
    theadClasses: function theadClasses() {
      return [this.headVariant ? "thead-".concat(this.headVariant) : null];
    },
    theadAttrs: function theadAttrs() {
      return _objectSpread({
        role: 'rowgroup'
      }, this.$attrs);
    }
  },
  render: function render(h) {
    return h('thead', {
      class: this.theadClasses,
      attrs: this.theadAttrs,
      // Pass down any native listeners
      on: this.$listeners
    }, this.normalizeSlot('default', {}));
  }
});

/***/ }),
/* 76 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__inspect__ = __webpack_require__(42);

/**
 * Convert a value to a string that can be rendered.
 */

var toString = function toString(val) {
  var spaces = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2;
  return Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["m" /* isUndefinedOrNull */])(val) ? '' : Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["a" /* isArray */])(val) || Object(__WEBPACK_IMPORTED_MODULE_0__inspect__["h" /* isPlainObject */])(val) && val.toString === Object.prototype.toString ? JSON.stringify(val, null, spaces) : String(val);
};

/* harmony default export */ __webpack_exports__["a"] = (toString);

/***/ }),
/* 77 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_config__ = __webpack_require__(58);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__tfoot__ = __webpack_require__(60);


/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    footClone: {
      type: Boolean,
      default: false
    },
    footVariant: {
      type: String,
      default: function _default() {
        return Object(__WEBPACK_IMPORTED_MODULE_0__utils_config__["a" /* getComponentConfig */])('BTable', 'footVariant');
      }
    },
    tfootClass: {
      type: [String, Array, Object],
      default: null
    },
    tfootTrClass: {
      type: [String, Array, Object],
      default: null
    }
  },
  methods: {
    renderTFootCustom: function renderTFootCustom() {
      var h = this.$createElement;

      if (this.hasNormalizedSlot('custom-foot')) {
        return h(__WEBPACK_IMPORTED_MODULE_1__tfoot__["a" /* BTfoot */], {
          key: 'bv-tfoot-custom',
          class: this.tfootClass || null,
          props: {
            footVariant: this.footVariant || this.headVariant || null
          }
        }, this.normalizeSlot('custom-foot', {
          items: this.computedItems.slice(),
          fields: this.computedFields.slice(),
          columns: this.computedFields.length
        }));
      } else {
        return h();
      }
    },
    renderTfoot: function renderTfoot() {
      // Passing true to renderThead will make it render a tfoot
      return this.footClone ? this.renderThead(true) : this.renderTFootCustom();
    }
  }
});

/***/ }),
/* 78 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__ = __webpack_require__(71);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_dom__ = __webpack_require__(59);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__tbody__ = __webpack_require__(79);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__filter_event__ = __webpack_require__(73);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__text_selection_active__ = __webpack_require__(74);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__mixin_tbody_row__ = __webpack_require__(91);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }









var props = _objectSpread({}, __WEBPACK_IMPORTED_MODULE_3__tbody__["b" /* props */], {
  tbodyClass: {
    type: [String, Array, Object] // default: undefined

  }
});

/* harmony default export */ __webpack_exports__["a"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_6__mixin_tbody_row__["a" /* default */]],
  props: props,
  methods: {
    // Helper methods
    getTbodyTrs: function getTbodyTrs() {
      // Returns all the item TR elements (excludes detail and spacer rows)
      // `this.$refs.itemRows` is an array of item TR components/elements
      // Rows should all be B-TR components, but we map to TR elements
      // TODO: This may take time for tables many rows, so we may want to cache
      //       the result of this during each render cycle on a non-reactive
      //       property. We clear out the cache as each render starts, and
      //       populate it on first access of this method if null
      return (this.$refs.itemRows || []).map(function (tr) {
        return tr.$el || tr;
      });
    },
    getTbodyTrIndex: function getTbodyTrIndex(el) {
      // Returns index of a particular TBODY item TR
      // We set `true` on closest to include self in result

      /* istanbul ignore next: should not normally happen */
      if (!Object(__WEBPACK_IMPORTED_MODULE_2__utils_dom__["e" /* isElement */])(el)) {
        return -1;
      }

      var tr = el.tagName === 'TR' ? el : Object(__WEBPACK_IMPORTED_MODULE_2__utils_dom__["a" /* closest */])('tr', el, true);
      return tr ? this.getTbodyTrs().indexOf(tr) : -1;
    },
    emitTbodyRowEvent: function emitTbodyRowEvent(type, evt) {
      // Emits a row event, with the item object, row index and original event
      if (type && evt && evt.target) {
        var rowIndex = this.getTbodyTrIndex(evt.target);

        if (rowIndex > -1) {
          // The array of TRs correlate to the `computedItems` array
          var item = this.computedItems[rowIndex];
          this.$emit(type, item, rowIndex, evt);
        }
      }
    },
    tbodyRowEvtStopped: function tbodyRowEvtStopped(evt) {
      return this.stopIfBusy && this.stopIfBusy(evt);
    },
    // Delegated row event handlers
    onTbodyRowKeydown: function onTbodyRowKeydown(evt) {
      // Keyboard navigation and row click emulation
      var target = evt.target;

      if (this.tbodyRowEvtStopped(evt) || target.tagName !== 'TR' || target !== document.activeElement || target.tabIndex !== 0) {
        // Early exit if not an item row TR
        return;
      }

      var keyCode = evt.keyCode;

      if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_array__["a" /* arrayIncludes */])([__WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].ENTER, __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].SPACE], keyCode)) {
        // Emulated click for keyboard users, transfer to click handler
        evt.stopPropagation();
        evt.preventDefault();
        this.onTBodyRowClicked(evt);
      } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_array__["a" /* arrayIncludes */])([__WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].UP, __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].DOWN, __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].HOME, __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].END], keyCode)) {
        // Keyboard navigation
        var rowIndex = this.getTbodyTrIndex(target);

        if (rowIndex > -1) {
          evt.stopPropagation();
          evt.preventDefault();
          var trs = this.getTbodyTrs();
          var shift = evt.shiftKey;

          if (keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].HOME || shift && keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].UP) {
            // Focus first row
            trs[0].focus();
          } else if (keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].END || shift && keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].DOWN) {
            // Focus last row
            trs[trs.length - 1].focus();
          } else if (keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].UP && rowIndex > 0) {
            // Focus previous row
            trs[rowIndex - 1].focus();
          } else if (keyCode === __WEBPACK_IMPORTED_MODULE_0__utils_key_codes__["a" /* default */].DOWN && rowIndex < trs.length - 1) {
            // Focus next row
            trs[rowIndex + 1].focus();
          }
        }
      }
    },
    onTBodyRowClicked: function onTBodyRowClicked(evt) {
      if (this.tbodyRowEvtStopped(evt)) {
        // If table is busy, then don't propagate
        return;
      } else if (Object(__WEBPACK_IMPORTED_MODULE_4__filter_event__["a" /* default */])(evt) || Object(__WEBPACK_IMPORTED_MODULE_5__text_selection_active__["a" /* default */])(this.$el)) {
        // Clicked on a non-disabled control so ignore
        // Or user is selecting text, so ignore
        return;
      }

      this.emitTbodyRowEvent('row-clicked', evt);
    },
    onTbodyRowMiddleMouseRowClicked: function onTbodyRowMiddleMouseRowClicked(evt) {
      if (!this.tbodyRowEvtStopped(evt) && evt.which === 2) {
        this.emitTbodyRowEvent('row-middle-clicked', evt);
      }
    },
    onTbodyRowContextmenu: function onTbodyRowContextmenu(evt) {
      if (!this.tbodyRowEvtStopped(evt)) {
        this.emitTbodyRowEvent('row-contextmenu', evt);
      }
    },
    onTbodyRowDblClicked: function onTbodyRowDblClicked(evt) {
      if (!this.tbodyRowEvtStopped(evt) && !Object(__WEBPACK_IMPORTED_MODULE_4__filter_event__["a" /* default */])(evt)) {
        this.emitTbodyRowEvent('row-dblclicked', evt);
      }
    },
    // Note: Row hover handlers are handled by the tbody-row mixin
    // As mouseenter/mouseleave events do not bubble
    //
    // Render Helper
    renderTbody: function renderTbody() {
      var _this = this;

      // Render the tbody element and children
      var items = this.computedItems; // Shortcut to `createElement` (could use `this._c()` instead)

      var h = this.$createElement;
      var hasRowClickHandler = this.$listeners['row-clicked'] || this.isSelectable; // Prepare the tbody rows

      var $rows = []; // Add the item data rows or the busy slot

      var $busy = this.renderBusy ? this.renderBusy() : null;

      if ($busy) {
        // If table is busy and a busy slot, then return only the busy "row" indicator
        $rows.push($busy);
      } else {
        // Table isn't busy, or we don't have a busy slot
        // Create a slot cache for improved performance when looking up cell slot names
        // Values will be keyed by the field's `key` and will store the slot's name
        // Slots could be dynamic (i.e. `v-if`), so we must compute on each render
        // Used by tbody-row mixin render helper
        var cache = {};
        var defaultSlotName = this.hasNormalizedSlot('cell()') ? 'cell()' : null;
        this.computedFields.forEach(function (field) {
          var key = field.key;
          var fullName = "cell(".concat(key, ")");
          var lowerName = "cell(".concat(key.toLowerCase(), ")");
          cache[key] = _this.hasNormalizedSlot(fullName) ? fullName : _this.hasNormalizedSlot(lowerName) ? lowerName : defaultSlotName;
        }); // Created as a non-reactive property so to not trigger component updates
        // Must be a fresh object each render

        this.$_bodyFieldSlotNameCache = cache; // Add static top row slot (hidden in visibly stacked mode
        // as we can't control `data-label` attr)

        $rows.push(this.renderTopRow ? this.renderTopRow() : h()); // Render the rows

        items.forEach(function (item, rowIndex) {
          // Render the individual item row (rows if details slot)
          $rows.push(_this.renderTbodyRow(item, rowIndex));
        }); // Empty items / empty filtered row slot (only shows if `items.length < 1`)

        $rows.push(this.renderEmpty ? this.renderEmpty() : h()); // Static bottom row slot (hidden in visibly stacked mode
        // as we can't control `data-label` attr)

        $rows.push(this.renderBottomRow ? this.renderBottomRow() : h());
      }

      var handlers = {
        // TODO: We may want to to only instantiate these handlers
        //       if there is an event listener registered
        auxclick: this.onTbodyRowMiddleMouseRowClicked,
        // TODO: Perhaps we do want to automatically prevent the
        //       default context menu from showing if there is
        //       a `row-contextmenu` listener registered.
        contextmenu: this.onTbodyRowContextmenu,
        // The following event(s) is not considered A11Y friendly
        dblclick: this.onTbodyRowDblClicked // hover events (mouseenter/mouseleave) ad handled by tbody-row mixin

      };

      if (hasRowClickHandler) {
        handlers.click = this.onTBodyRowClicked;
        handlers.keydown = this.onTbodyRowKeydown;
      } // Assemble rows into the tbody


      var $tbody = h(__WEBPACK_IMPORTED_MODULE_3__tbody__["a" /* BTbody */], {
        ref: 'tbody',
        class: this.tbodyClass || null,
        props: {
          tbodyTransitionProps: this.tbodyTransitionProps,
          tbodyTransitionHandlers: this.tbodyTransitionHandlers
        },
        // BTbody transfers all native event listeners to the root element
        // TODO: Only set the handlers if the table is not busy
        on: handlers
      }, $rows); // Return the assembled tbody

      return $tbody;
    }
  }
});

/***/ }),
/* 79 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return props; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTbody; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__ = __webpack_require__(46);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



var props = {
  tbodyTransitionProps: {
    type: Object // default: undefined

  },
  tbodyTransitionHandlers: {
    type: Object // default: undefined

  }
}; // @vue/component

var BTbody =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTbody',
  mixins: [__WEBPACK_IMPORTED_MODULE_1__mixins_normalize_slot__["a" /* default */]],
  inheritAttrs: false,
  provide: function provide() {
    return {
      bvTableRowGroup: this
    };
  },
  inject: {
    bvTable: {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      default: function _default()
      /* istanbul ignore next */
      {
        return {};
      }
    }
  },
  props: props,
  computed: {
    isTbody: function isTbody() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return true;
    },
    isDark: function isDark() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.dark;
    },
    isStacked: function isStacked() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.isStacked;
    },
    isResponsive: function isResponsive() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.isResponsive;
    },
    isStickyHeader: function isStickyHeader() {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      // Sticky headers are only supported in thead
      return false;
    },
    tableVariant: function tableVariant()
    /* istanbul ignore next: Not currently sniffed in tests */
    {
      // Sniffed by <b-tr> / <b-td> / <b-th>
      return this.bvTable.tableVariant;
    },
    isTransitionGroup: function isTransitionGroup() {
      return this.tbodyTransitionProps || this.tbodyTransitionHandlers;
    },
    tbodyAttrs: function tbodyAttrs() {
      return _objectSpread({
        role: 'rowgroup'
      }, this.$attrs);
    },
    tbodyProps: function tbodyProps() {
      return this.tbodyTransitionProps ? _objectSpread({}, this.tbodyTransitionProps, {
        tag: 'tbody'
      }) : {};
    },
    tbodyListeners: function tbodyListeners() {
      var handlers = this.tbodyTransitionHandlers || {};
      return _objectSpread({}, this.$listeners, {}, handlers);
    }
  },
  render: function render(h) {
    return h(this.isTransitionGroup ? 'transition-group' : 'tbody', {
      props: this.tbodyProps,
      attrs: this.tbodyAttrs,
      // Pass down any listeners
      on: this.tbodyListeners
    }, this.normalizeSlot('default', {}));
  }
});

/***/ }),
/* 80 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTable; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_id__ = __webpack_require__(52);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mixins_normalize_slot__ = __webpack_require__(46);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__helpers_mixin_items__ = __webpack_require__(65);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_stacked__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__helpers_mixin_filtering__ = __webpack_require__(84);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__helpers_mixin_sorting__ = __webpack_require__(86);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__helpers_mixin_pagination__ = __webpack_require__(89);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__helpers_mixin_caption__ = __webpack_require__(68);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__helpers_mixin_colgroup__ = __webpack_require__(69);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__helpers_mixin_thead__ = __webpack_require__(70);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__helpers_mixin_tfoot__ = __webpack_require__(77);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__helpers_mixin_tbody__ = __webpack_require__(78);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__helpers_mixin_empty__ = __webpack_require__(92);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__helpers_mixin_top_row__ = __webpack_require__(93);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__helpers_mixin_bottom_row__ = __webpack_require__(94);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__helpers_mixin_busy__ = __webpack_require__(95);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__helpers_mixin_selectable__ = __webpack_require__(96);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__helpers_mixin_provider__ = __webpack_require__(98);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__helpers_mixin_table_renderer__ = __webpack_require__(63);
 // Mixins


 // Table helper Mixins
















 // Main table renderer mixin

 // b-table component definition
// @vue/component

var BTable =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTable',
  // Order of mixins is important!
  // They are merged from first to last, followed by this component.
  mixins: [// Required Mixins
  __WEBPACK_IMPORTED_MODULE_1__mixins_id__["a" /* default */], __WEBPACK_IMPORTED_MODULE_2__mixins_normalize_slot__["a" /* default */], __WEBPACK_IMPORTED_MODULE_3__helpers_mixin_items__["a" /* default */], __WEBPACK_IMPORTED_MODULE_19__helpers_mixin_table_renderer__["a" /* default */], __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_stacked__["a" /* default */], __WEBPACK_IMPORTED_MODULE_10__helpers_mixin_thead__["a" /* default */], __WEBPACK_IMPORTED_MODULE_11__helpers_mixin_tfoot__["a" /* default */], __WEBPACK_IMPORTED_MODULE_12__helpers_mixin_tbody__["a" /* default */], // Features Mixins
  __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_stacked__["a" /* default */], __WEBPACK_IMPORTED_MODULE_5__helpers_mixin_filtering__["a" /* default */], __WEBPACK_IMPORTED_MODULE_6__helpers_mixin_sorting__["a" /* default */], __WEBPACK_IMPORTED_MODULE_7__helpers_mixin_pagination__["a" /* default */], __WEBPACK_IMPORTED_MODULE_8__helpers_mixin_caption__["a" /* default */], __WEBPACK_IMPORTED_MODULE_9__helpers_mixin_colgroup__["a" /* default */], __WEBPACK_IMPORTED_MODULE_17__helpers_mixin_selectable__["a" /* default */], __WEBPACK_IMPORTED_MODULE_13__helpers_mixin_empty__["a" /* default */], __WEBPACK_IMPORTED_MODULE_14__helpers_mixin_top_row__["a" /* default */], __WEBPACK_IMPORTED_MODULE_15__helpers_mixin_bottom_row__["a" /* default */], __WEBPACK_IMPORTED_MODULE_16__helpers_mixin_busy__["a" /* default */], __WEBPACK_IMPORTED_MODULE_18__helpers_mixin_provider__["a" /* default */]] // render function provided by table-renderer mixin

});

/***/ }),
/* 81 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return hasNormalizedSlot; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return normalizeSlot; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__inspect__ = __webpack_require__(42);

 // Note for functional components:
// In functional components, `slots` is a function so it must be called
// first before passing to the below methods. `scopedSlots` is always an
// object and may be undefined (for Vue < 2.6.x)

/**
 * Returns true if either scoped or unscoped named slot exists
 *
 * @param {String, Array} name or name[]
 * @param {Object} scopedSlots
 * @param {Object} slots
 * @returns {Array|undefined} VNodes
 */

var hasNormalizedSlot = function hasNormalizedSlot(names) {
  var $scopedSlots = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var $slots = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  // Ensure names is an array
  names = Object(__WEBPACK_IMPORTED_MODULE_0__array__["b" /* concat */])(names).filter(Boolean); // Returns true if the either a $scopedSlot or $slot exists with the specified name

  return names.some(function (name) {
    return $scopedSlots[name] || $slots[name];
  });
};
/**
 * Returns VNodes for named slot either scoped or unscoped
 *
 * @param {String, Array} name or name[]
 * @param {String} scope
 * @param {Object} scopedSlots
 * @param {Object} slots
 * @returns {Array|undefined} VNodes
 */


var normalizeSlot = function normalizeSlot(names) {
  var scope = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  var $scopedSlots = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  var $slots = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {};
  // Ensure names is an array
  names = Object(__WEBPACK_IMPORTED_MODULE_0__array__["b" /* concat */])(names).filter(Boolean);
  var slot;

  for (var i = 0; i < names.length && !slot; i++) {
    var name = names[i];
    slot = $scopedSlots[name] || $slots[name];
  } // Note: in Vue 2.6.x, all named slots are also scoped slots


  return Object(__WEBPACK_IMPORTED_MODULE_1__inspect__["d" /* isFunction */])(slot) ? slot(scope) : slot;
}; // Named exports


 // Default export (backwards compatibility)

/* unused harmony default export */ var _unused_webpack_default_export = (normalizeSlot);

/***/ }),
/* 82 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export Element */
/* unused harmony export HTMLElement */
/* unused harmony export SVGElement */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return File; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__env__ = __webpack_require__(49);
function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _wrapNativeSuper(Class) { var _cache = typeof Map === "function" ? new Map() : undefined; _wrapNativeSuper = function _wrapNativeSuper(Class) { if (Class === null || !_isNativeFunction(Class)) return Class; if (typeof Class !== "function") { throw new TypeError("Super expression must either be null or a function"); } if (typeof _cache !== "undefined") { if (_cache.has(Class)) return _cache.get(Class); _cache.set(Class, Wrapper); } function Wrapper() { return _construct(Class, arguments, _getPrototypeOf(this).constructor); } Wrapper.prototype = Object.create(Class.prototype, { constructor: { value: Wrapper, enumerable: false, writable: true, configurable: true } }); return _setPrototypeOf(Wrapper, Class); }; return _wrapNativeSuper(Class); }

function isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _construct(Parent, args, Class) { if (isNativeReflectConstruct()) { _construct = Reflect.construct; } else { _construct = function _construct(Parent, args, Class) { var a = [null]; a.push.apply(a, args); var Constructor = Function.bind.apply(Parent, a); var instance = new Constructor(); if (Class) _setPrototypeOf(instance, Class.prototype); return instance; }; } return _construct.apply(null, arguments); }

function _isNativeFunction(fn) { return Function.toString.call(fn).indexOf("[native code]") !== -1; }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

/**
 * SSR safe types
 */

var w = __WEBPACK_IMPORTED_MODULE_0__env__["f" /* hasWindowSupport */] ? window : {};
var Element = __WEBPACK_IMPORTED_MODULE_0__env__["f" /* hasWindowSupport */] ? w.Element :
/*#__PURE__*/
function (_Object) {
  _inherits(Element, _Object);

  function Element() {
    _classCallCheck(this, Element);

    return _possibleConstructorReturn(this, _getPrototypeOf(Element).apply(this, arguments));
  }

  return Element;
}(_wrapNativeSuper(Object));
var HTMLElement = __WEBPACK_IMPORTED_MODULE_0__env__["f" /* hasWindowSupport */] ? w.HTMLElement :
/*#__PURE__*/
function (_Element) {
  _inherits(HTMLElement, _Element);

  function HTMLElement() {
    _classCallCheck(this, HTMLElement);

    return _possibleConstructorReturn(this, _getPrototypeOf(HTMLElement).apply(this, arguments));
  }

  return HTMLElement;
}(Element);
var SVGElement = __WEBPACK_IMPORTED_MODULE_0__env__["f" /* hasWindowSupport */] ? w.SVGElement :
/*#__PURE__*/
function (_Element2) {
  _inherits(SVGElement, _Element2);

  function SVGElement() {
    _classCallCheck(this, SVGElement);

    return _possibleConstructorReturn(this, _getPrototypeOf(SVGElement).apply(this, arguments));
  }

  return SVGElement;
}(Element);
var File = __WEBPACK_IMPORTED_MODULE_0__env__["f" /* hasWindowSupport */] ? w.File :
/*#__PURE__*/
function (_Object2) {
  _inherits(File, _Object2);

  function File() {
    _classCallCheck(this, File);

    return _possibleConstructorReturn(this, _getPrototypeOf(File).apply(this, arguments));
  }

  return File;
}(_wrapNativeSuper(Object));

/***/ }),
/* 83 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_startcase__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_object__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__constants__ = __webpack_require__(54);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }




 // Private function to massage field entry into common object format

var processField = function processField(key, value) {
  var field = null;

  if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["k" /* isString */])(value)) {
    // Label shortcut
    field = {
      key: key,
      label: value
    };
  } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["d" /* isFunction */])(value)) {
    // Formatter shortcut
    field = {
      key: key,
      formatter: value
    };
  } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["g" /* isObject */])(value)) {
    field = _objectSpread({}, value);
    field.key = field.key || key;
  } else if (value !== false) {
    // Fallback to just key

    /* istanbul ignore next */
    field = {
      key: key
    };
  }

  return field;
}; // We normalize fields into an array of objects
// [ { key:..., label:..., ...}, {...}, ..., {..}]


var normalizeFields = function normalizeFields(origFields, items) {
  var fields = [];

  if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["a" /* isArray */])(origFields)) {
    // Normalize array Form
    origFields.filter(function (f) {
      return f;
    }).forEach(function (f) {
      if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["k" /* isString */])(f)) {
        fields.push({
          key: f,
          label: Object(__WEBPACK_IMPORTED_MODULE_0__utils_startcase__["a" /* default */])(f)
        });
      } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["g" /* isObject */])(f) && f.key && Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["k" /* isString */])(f.key)) {
        // Full object definition. We use assign so that we don't mutate the original
        fields.push(_objectSpread({}, f));
      } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["g" /* isObject */])(f) && Object(__WEBPACK_IMPORTED_MODULE_2__utils_object__["g" /* keys */])(f).length === 1) {
        // Shortcut object (i.e. { 'foo_bar': 'This is Foo Bar' }
        var key = Object(__WEBPACK_IMPORTED_MODULE_2__utils_object__["g" /* keys */])(f)[0];
        var field = processField(key, f[key]);

        if (field) {
          fields.push(field);
        }
      }
    });
  } // If no field provided, take a sample from first record (if exits)


  if (fields.length === 0 && Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["a" /* isArray */])(items) && items.length > 0) {
    var sample = items[0];
    Object(__WEBPACK_IMPORTED_MODULE_2__utils_object__["g" /* keys */])(sample).forEach(function (k) {
      if (!__WEBPACK_IMPORTED_MODULE_3__constants__["b" /* IGNORED_FIELD_KEYS */][k]) {
        fields.push({
          key: k,
          label: Object(__WEBPACK_IMPORTED_MODULE_0__utils_startcase__["a" /* default */])(k)
        });
      }
    });
  } // Ensure we have a unique array of fields and that they have String labels


  var memo = {};
  return fields.filter(function (f) {
    if (!memo[f.key]) {
      memo[f.key] = true;
      f.label = Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["k" /* isString */])(f.label) ? f.label : Object(__WEBPACK_IMPORTED_MODULE_0__utils_startcase__["a" /* default */])(f.key);
      return true;
    }

    return false;
  });
};

/* harmony default export */ __webpack_exports__["a"] = (normalizeFields);

/***/ }),
/* 84 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_clone_deep__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_loose_equal__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__stringify_record_values__ = __webpack_require__(85);





/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    filter: {
      type: [String, RegExp, Object, Array],
      default: null
    },
    filterFunction: {
      type: Function,
      default: null
    },
    filterIgnoredFields: {
      type: Array // default: undefined

    },
    filterIncludedFields: {
      type: Array // default: undefined

    },
    filterDebounce: {
      type: [Number, String],
      default: 0,
      validator: function validator(val) {
        return /^\d+/.test(String(val));
      }
    }
  },
  data: function data() {
    return {
      // Flag for displaying which empty slot to show and some event triggering
      isFiltered: false,
      // Where we store the copy of the filter criteria after debouncing
      // We pre-set it with the sanitized filter value
      localFilter: this.filterSanitize(this.filter)
    };
  },
  computed: {
    computedFilterIgnored: function computedFilterIgnored() {
      return this.filterIgnoredFields ? Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["b" /* concat */])(this.filterIgnoredFields).filter(Boolean) : null;
    },
    computedFilterIncluded: function computedFilterIncluded() {
      return this.filterIncludedFields ? Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["b" /* concat */])(this.filterIncludedFields).filter(Boolean) : null;
    },
    computedFilterDebounce: function computedFilterDebounce() {
      return parseInt(this.filterDebounce, 10) || 0;
    },
    localFiltering: function localFiltering() {
      return this.hasProvider ? !!this.noProviderFiltering : true;
    },
    // For watching changes to `filteredItems` vs `localItems`
    filteredCheck: function filteredCheck() {
      return {
        filteredItems: this.filteredItems,
        localItems: this.localItems,
        localFilter: this.localFilter
      };
    },
    // Sanitized/normalize filter-function prop
    localFilterFn: function localFilterFn() {
      // Return `null` to signal to use internal filter function
      return Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["d" /* isFunction */])(this.filterFunction) ? this.filterFunction : null;
    },
    // Returns the records in `localItems` that match the filter criteria
    // Returns the original `localItems` array if not sorting
    filteredItems: function filteredItems() {
      var items = this.localItems || []; // Note the criteria is debounced and sanitized

      var criteria = this.localFilter; // Resolve the filtering function, when requested
      // We prefer the provided filtering function and fallback to the internal one
      // When no filtering criteria is specified the filtering factories will return `null`

      var filterFn = this.localFiltering ? this.filterFnFactory(this.localFilterFn, criteria) || this.defaultFilterFnFactory(criteria) : null; // We only do local filtering when requested and there are records to filter

      return filterFn && items.length > 0 ? items.filter(filterFn) : items;
    }
  },
  watch: {
    // Watch for debounce being set to 0
    computedFilterDebounce: function computedFilterDebounce(newVal, oldVal) {
      if (!newVal && this.$_filterTimer) {
        clearTimeout(this.$_filterTimer);
        this.$_filterTimer = null;
        this.localFilter = this.filterSanitize(this.filter);
      }
    },
    // Watch for changes to the filter criteria, and debounce if necessary
    filter: {
      // We need a deep watcher in case the user passes
      // an object when using `filter-function`
      deep: true,
      handler: function handler(newCriteria, oldCriteria) {
        var _this = this;

        var timeout = this.computedFilterDebounce;
        clearTimeout(this.$_filterTimer);
        this.$_filterTimer = null;

        if (timeout && timeout > 0) {
          // If we have a debounce time, delay the update of `localFilter`
          this.$_filterTimer = setTimeout(function () {
            _this.localFilter = _this.filterSanitize(newCriteria);
          }, timeout);
        } else {
          // Otherwise, immediately update `localFilter` with `newFilter` value
          this.localFilter = this.filterSanitize(newCriteria);
        }
      }
    },
    // Watch for changes to the filter criteria and filtered items vs `localItems`
    // Set visual state and emit events as required
    filteredCheck: function filteredCheck(_ref) {
      var filteredItems = _ref.filteredItems,
          localItems = _ref.localItems,
          localFilter = _ref.localFilter;
      // Determine if the dataset is filtered or not
      var isFiltered = false;

      if (!localFilter) {
        // If filter criteria is falsey
        isFiltered = false;
      } else if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_loose_equal__["a" /* default */])(localFilter, []) || Object(__WEBPACK_IMPORTED_MODULE_1__utils_loose_equal__["a" /* default */])(localFilter, {})) {
        // If filter criteria is an empty array or object
        isFiltered = false;
      } else if (localFilter) {
        // If filter criteria is truthy
        isFiltered = true;
      }

      if (isFiltered) {
        this.$emit('filtered', filteredItems, filteredItems.length);
      }

      this.isFiltered = isFiltered;
    },
    isFiltered: function isFiltered(newVal, oldVal) {
      if (newVal === false && oldVal === true) {
        // We need to emit a filtered event if isFiltered transitions from true to
        // false so that users can update their pagination controls.
        this.$emit('filtered', this.localItems, this.localItems.length);
      }
    }
  },
  created: function created() {
    var _this2 = this;

    // Create non-reactive prop where we store the debounce timer id
    this.$_filterTimer = null; // If filter is "pre-set", set the criteria
    // This will trigger any watchers/dependents
    // this.localFilter = this.filterSanitize(this.filter)
    // Set the initial filtered state in a `$nextTick()` so that
    // we trigger a filtered event if needed

    this.$nextTick(function () {
      _this2.isFiltered = Boolean(_this2.localFilter);
    });
  },
  beforeDestroy: function beforeDestroy()
  /* istanbul ignore next */
  {
    clearTimeout(this.$_filterTimer);
    this.$_filterTimer = null;
  },
  methods: {
    filterSanitize: function filterSanitize(criteria) {
      // Sanitizes filter criteria based on internal or external filtering
      if (this.localFiltering && !this.localFilterFn && !(Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["k" /* isString */])(criteria) || Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["j" /* isRegExp */])(criteria))) {
        // If using internal filter function, which only accepts string or RegExp,
        // return '' to signify no filter
        return '';
      } // Could be a string, object or array, as needed by external filter function
      // We use `cloneDeep` to ensure we have a new copy of an object or array
      // without Vue's reactive observers


      return Object(__WEBPACK_IMPORTED_MODULE_0__utils_clone_deep__["a" /* default */])(criteria);
    },
    // Filter Function factories
    filterFnFactory: function filterFnFactory(filterFn, criteria) {
      // Wrapper factory for external filter functions
      // Wrap the provided filter-function and return a new function
      // Returns `null` if no filter-function defined or if criteria is falsey
      // Rather than directly grabbing `this.computedLocalFilterFn` or `this.filterFunction`
      // we have it passed, so that the caller computed prop will be reactive to changes
      // in the original filter-function (as this routine is a method)
      if (!filterFn || !Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["d" /* isFunction */])(filterFn) || !criteria || Object(__WEBPACK_IMPORTED_MODULE_1__utils_loose_equal__["a" /* default */])(criteria, []) || Object(__WEBPACK_IMPORTED_MODULE_1__utils_loose_equal__["a" /* default */])(criteria, {})) {
        return null;
      } // Build the wrapped filter test function, passing the criteria to the provided function


      var fn = function fn(item) {
        // Generated function returns true if the criteria matches part
        // of the serialized data, otherwise false
        return filterFn(item, criteria);
      }; // Return the wrapped function


      return fn;
    },
    defaultFilterFnFactory: function defaultFilterFnFactory(criteria) {
      var _this3 = this;

      // Generates the default filter function, using the given filter criteria
      // Returns `null` if no criteria or criteria format not supported
      if (!criteria || !(Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["k" /* isString */])(criteria) || Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["j" /* isRegExp */])(criteria))) {
        // Built in filter can only support strings or RegExp criteria (at the moment)
        return null;
      } // Build the regexp needed for filtering


      var regexp = criteria;

      if (Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["k" /* isString */])(regexp)) {
        // Escape special `RegExp` characters in the string and convert contiguous
        // whitespace to `\s+` matches
        var pattern = criteria.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&').replace(/[\s\uFEFF\xA0]+/g, '\\s+'); // Build the `RegExp` (no need for global flag, as we only need
        // to find the value once in the string)

        regexp = new RegExp(".*".concat(pattern, ".*"), 'i');
      } // Generate the wrapped filter test function to use


      var fn = function fn(item) {
        // This searches all row values (and sub property values) in the entire (excluding
        // special `_` prefixed keys), because we convert the record to a space-separated
        // string containing all the value properties (recursively), even ones that are
        // not visible (not specified in this.fields)
        // Users can ignore filtering on specific fields, or on only certain fields,
        // and can optionall specify searching results of fields with formatter
        //
        // TODO: Enable searching on scoped slots (optional, as it will be SLOW)
        //
        // Generated function returns true if the criteria matches part of
        // the serialized data, otherwise false
        // We set `lastIndex = 0` on the `RegExp` in case someone specifies the `/g` global flag
        regexp.lastIndex = 0;
        return regexp.test(Object(__WEBPACK_IMPORTED_MODULE_4__stringify_record_values__["a" /* default */])(item, _this3.computedFilterIgnored, _this3.computedFilterIncluded, _this3.computedFieldsObj));
      }; // Return the generated function


      return fn;
    }
  }
});

/***/ }),
/* 85 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__sanitize_row__ = __webpack_require__(66);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__stringify_object_values__ = __webpack_require__(67);


 // Stringifies the values of a record, ignoring any special top level field keys
// TODO: Add option to stringify `scopedSlot` items

var stringifyRecordValues = function stringifyRecordValues(row, ignoreFields, includeFields, fieldsObj) {
  return Object(__WEBPACK_IMPORTED_MODULE_0__utils_inspect__["g" /* isObject */])(row) ? Object(__WEBPACK_IMPORTED_MODULE_2__stringify_object_values__["a" /* default */])(Object(__WEBPACK_IMPORTED_MODULE_1__sanitize_row__["a" /* default */])(row, ignoreFields, includeFields, fieldsObj)) : '';
};

/* harmony default export */ __webpack_exports__["a"] = (stringifyRecordValues);

/***/ }),
/* 86 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_stable_sort__ = __webpack_require__(87);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_startcase__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__default_sort_compare__ = __webpack_require__(88);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }






/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    sortBy: {
      type: String,
      default: ''
    },
    sortDesc: {
      // TODO: Make this tri-state: true, false, null
      type: Boolean,
      default: false
    },
    sortDirection: {
      // This prop is named incorrectly
      // It should be `initialSortDirection` as it is a bit misleading
      // (not to mention it screws up the ARIA label on the headers)
      type: String,
      default: 'asc',
      validator: function validator(direction) {
        return Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["a" /* arrayIncludes */])(['asc', 'desc', 'last'], direction);
      }
    },
    sortCompare: {
      type: Function,
      default: null
    },
    sortCompareOptions: {
      // Supported localCompare options, see `options` section of:
      // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/localeCompare
      type: Object,
      default: function _default() {
        return {
          numeric: true
        };
      }
    },
    sortCompareLocale: {
      // String: locale code
      // Array: array of Locale strings
      type: [String, Array] // default: undefined

    },
    sortNullLast: {
      // Sort null and undefined to appear last
      type: Boolean,
      default: false
    },
    noSortReset: {
      // Another prop that should have had a better name.
      // It should be noSortClear (on non-sortable headers).
      // We will need to make sure the documentation is clear on what
      // this prop does (as well as in the code for future reference)
      type: Boolean,
      default: false
    },
    labelSortAsc: {
      type: String,
      default: 'Click to sort Ascending'
    },
    labelSortDesc: {
      type: String,
      default: 'Click to sort Descending'
    },
    labelSortClear: {
      type: String,
      default: 'Click to clear sorting'
    },
    noLocalSorting: {
      type: Boolean,
      default: false
    },
    noFooterSorting: {
      type: Boolean,
      default: false
    },
    sortIconLeft: {
      // Place the sorting icon on the left of the header cells
      type: Boolean,
      default: false
    }
  },
  data: function data() {
    return {
      localSortBy: this.sortBy || '',
      localSortDesc: this.sortDesc || false
    };
  },
  computed: {
    localSorting: function localSorting() {
      return this.hasProvider ? !!this.noProviderSorting : !this.noLocalSorting;
    },
    isSortable: function isSortable() {
      return this.computedFields.some(function (f) {
        return f.sortable;
      });
    },
    sortedItems: function sortedItems() {
      // Sorts the filtered items and returns a new array of the sorted items
      // or the original items array if not sorted.
      var items = (this.filteredItems || this.localItems || []).slice();
      var sortBy = this.localSortBy;
      var sortDesc = this.localSortDesc;
      var sortCompare = this.sortCompare;
      var localSorting = this.localSorting;

      var sortOptions = _objectSpread({}, this.sortCompareOptions, {
        usage: 'sort'
      });

      var sortLocale = this.sortCompareLocale || undefined;
      var nullLast = this.sortNullLast;

      if (sortBy && localSorting) {
        var field = this.computedFieldsObj[sortBy] || {};
        var sortByFormatted = field.sortByFormatted;
        var formatter = Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["d" /* isFunction */])(sortByFormatted) ? sortByFormatted : sortByFormatted ? this.getFieldFormatter(sortBy) : undefined; // `stableSort` returns a new array, and leaves the original array intact

        return Object(__WEBPACK_IMPORTED_MODULE_0__utils_stable_sort__["a" /* default */])(items, function (a, b) {
          var result = null;

          if (Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["d" /* isFunction */])(sortCompare)) {
            // Call user provided sortCompare routine
            result = sortCompare(a, b, sortBy, sortDesc, formatter, sortOptions, sortLocale);
          }

          if (Object(__WEBPACK_IMPORTED_MODULE_3__utils_inspect__["m" /* isUndefinedOrNull */])(result) || result === false) {
            // Fallback to built-in defaultSortCompare if sortCompare
            // is not defined or returns null/false
            result = Object(__WEBPACK_IMPORTED_MODULE_4__default_sort_compare__["a" /* default */])(a, b, sortBy, sortDesc, formatter, sortOptions, sortLocale, nullLast);
          } // Negate result if sorting in descending order


          return (result || 0) * (sortDesc ? -1 : 1);
        });
      }

      return items;
    }
  },
  watch: {
    isSortable: function isSortable(newVal, oldVal)
    /* istanbul ignore next: pain in the butt to test */
    {
      if (newVal) {
        if (this.isSortable) {
          this.$on('head-clicked', this.handleSort);
        }
      } else {
        this.$off('head-clicked', this.handleSort);
      }
    },
    sortDesc: function sortDesc(newVal, oldVal) {
      if (newVal === this.localSortDesc) {
        /* istanbul ignore next */
        return;
      }

      this.localSortDesc = newVal || false;
    },
    sortBy: function sortBy(newVal, oldVal) {
      if (newVal === this.localSortBy) {
        /* istanbul ignore next */
        return;
      }

      this.localSortBy = newVal || '';
    },
    // Update .sync props
    localSortDesc: function localSortDesc(newVal, oldVal) {
      // Emit update to sort-desc.sync
      if (newVal !== oldVal) {
        this.$emit('update:sortDesc', newVal);
      }
    },
    localSortBy: function localSortBy(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.$emit('update:sortBy', newVal);
      }
    }
  },
  created: function created() {
    if (this.isSortable) {
      this.$on('head-clicked', this.handleSort);
    }
  },
  methods: {
    // Handlers
    // Need to move from thead-mixin
    handleSort: function handleSort(key, field, evt, isFoot) {
      var _this = this;

      if (!this.isSortable) {
        /* istanbul ignore next */
        return;
      }

      if (isFoot && this.noFooterSorting) {
        return;
      } // TODO: make this tri-state sorting
      // cycle desc => asc => none => desc => ...


      var sortChanged = false;

      var toggleLocalSortDesc = function toggleLocalSortDesc() {
        var sortDirection = field.sortDirection || _this.sortDirection;

        if (sortDirection === 'asc') {
          _this.localSortDesc = false;
        } else if (sortDirection === 'desc') {
          _this.localSortDesc = true;
        } else {// sortDirection === 'last'
          // Leave at last sort direction from previous column
        }
      };

      if (field.sortable) {
        if (key === this.localSortBy) {
          // Change sorting direction on current column
          this.localSortDesc = !this.localSortDesc;
        } else {
          // Start sorting this column ascending
          this.localSortBy = key; // this.localSortDesc = false

          toggleLocalSortDesc();
        }

        sortChanged = true;
      } else if (this.localSortBy && !this.noSortReset) {
        this.localSortBy = '';
        toggleLocalSortDesc();
        sortChanged = true;
      }

      if (sortChanged) {
        // Sorting parameters changed
        this.$emit('sort-changed', this.context);
      }
    },
    // methods to compute classes and attrs for thead>th cells
    sortTheadThClasses: function sortTheadThClasses(key, field, isFoot) {
      return {
        // If sortable and sortIconLeft are true, then place sort icon on the left
        'b-table-sort-icon-left': field.sortable && this.sortIconLeft && !(isFoot && this.noFooterSorting)
      };
    },
    sortTheadThAttrs: function sortTheadThAttrs(key, field, isFoot) {
      if (!this.isSortable || isFoot && this.noFooterSorting) {
        // No attributes if not a sortable table
        return {};
      }

      var sortable = field.sortable;
      var ariaLabel = '';

      if ((!field.label || !field.label.trim()) && !field.headerTitle) {
        // In case field's label and title are empty/blank, we need to
        // add a hint about what the column is about for non-sighted users.
        // This is duplicated code from tbody-row mixin, but we need it
        // here as well, since we overwrite the original aria-label.

        /* istanbul ignore next */
        ariaLabel = Object(__WEBPACK_IMPORTED_MODULE_1__utils_startcase__["a" /* default */])(key);
      } // The correctness of these labels is very important for screen-reader users.


      var ariaLabelSorting = '';

      if (sortable) {
        if (this.localSortBy === key) {
          // currently sorted sortable column.
          ariaLabelSorting = this.localSortDesc ? this.labelSortAsc : this.labelSortDesc;
        } else {
          // Not currently sorted sortable column.
          // Not using nested ternary's here for clarity/readability
          // Default for ariaLabel
          ariaLabelSorting = this.localSortDesc ? this.labelSortDesc : this.labelSortAsc; // Handle sortDirection setting

          var sortDirection = this.sortDirection || field.sortDirection;

          if (sortDirection === 'asc') {
            ariaLabelSorting = this.labelSortAsc;
          } else if (sortDirection === 'desc') {
            ariaLabelSorting = this.labelSortDesc;
          }
        }
      } else if (!this.noSortReset) {
        // Non sortable column
        ariaLabelSorting = this.localSortBy ? this.labelSortClear : '';
      } // Assemble the aria-label attribute value


      ariaLabel = [ariaLabel.trim(), ariaLabelSorting.trim()].filter(Boolean).join(': '); // Assemble the aria-sort attribute value

      var ariaSort = sortable && this.localSortBy === key ? this.localSortDesc ? 'descending' : 'ascending' : sortable ? 'none' : null; // Return the attributes
      // (All the above just to get these two values)

      return {
        'aria-label': ariaLabel || null,
        'aria-sort': ariaSort
      };
    }
  }
});

/***/ }),
/* 87 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/*
 * Consistent and stable sort function across JavaScript platforms
 *
 * Inconsistent sorts can cause SSR problems between client and server
 * such as in <b-table> if sortBy is applied to the data on server side render.
 * Chrome and V8 native sorts are inconsistent/unstable
 *
 * This function uses native sort with fallback to index compare when the a and b
 * compare returns 0
 *
 * Algorithm based on:
 * https://stackoverflow.com/questions/1427608/fast-stable-sorting-algorithm-implementation-in-javascript/45422645#45422645
 *
 * @param {array} array to sort
 * @param {function} sort compare function
 * @return {array}
 */
var stableSort = function stableSort(array, compareFn) {
  // Using `.bind(compareFn)` on the wrapped anonymous function improves
  // performance by avoiding the function call setup. We don't use an arrow
  // function here as it binds `this` to the `stableSort` context rather than
  // the `compareFn` context, which wouldn't give us the performance increase.
  return array.map(function (a, index) {
    return [index, a];
  }).sort(function (a, b) {
    return this(a[1], b[1]) || a[0] - b[0];
  }.bind(compareFn)).map(function (e) {
    return e[1];
  });
};

/* harmony default export */ __webpack_exports__["a"] = (stableSort);

/***/ }),
/* 88 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_get__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__stringify_object_values__ = __webpack_require__(67);


 // Default sort compare routine
//
// TODO: Add option to sort by multiple columns (tri-state per column,
//       plus order of columns in sort)  where sortBy could be an array
//       of objects `[ {key: 'foo', sortDir: 'asc'}, {key:'bar', sortDir: 'desc'} ...]`
//       or an array of arrays `[ ['foo','asc'], ['bar','desc'] ]`
//       Multisort will most likely be handled in mixin-sort.js by
//       calling this method for each sortBy

var defaultSortCompare = function defaultSortCompare(a, b, sortBy, sortDesc, formatter, localeOpts, locale, nullLast) {
  var aa = Object(__WEBPACK_IMPORTED_MODULE_0__utils_get__["a" /* default */])(a, sortBy, null);
  var bb = Object(__WEBPACK_IMPORTED_MODULE_0__utils_get__["a" /* default */])(b, sortBy, null);

  if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["d" /* isFunction */])(formatter)) {
    aa = formatter(aa, sortBy, a);
    bb = formatter(bb, sortBy, b);
  }

  aa = Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["m" /* isUndefinedOrNull */])(aa) ? '' : aa;
  bb = Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["m" /* isUndefinedOrNull */])(bb) ? '' : bb;

  if (Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["c" /* isDate */])(aa) && Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["c" /* isDate */])(bb) || Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["f" /* isNumber */])(aa) && Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["f" /* isNumber */])(bb)) {
    // Special case for comparing dates and numbers
    // Internally dates are compared via their epoch number values
    return aa < bb ? -1 : aa > bb ? 1 : 0;
  } else if (nullLast && aa === '' && bb !== '') {
    // Special case when sorting null/undefined/empty string last
    return 1;
  } else if (nullLast && aa !== '' && bb === '') {
    // Special case when sorting null/undefined/empty string last
    return -1;
  } // Do localized string comparison


  return Object(__WEBPACK_IMPORTED_MODULE_2__stringify_object_values__["a" /* default */])(aa).localeCompare(Object(__WEBPACK_IMPORTED_MODULE_2__stringify_object_values__["a" /* default */])(bb), locale, localeOpts);
};

/* harmony default export */ __webpack_exports__["a"] = (defaultSortCompare);

/***/ }),
/* 89 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    perPage: {
      type: [Number, String],
      default: 0
    },
    currentPage: {
      type: [Number, String],
      default: 1
    }
  },
  computed: {
    localPaging: function localPaging() {
      return this.hasProvider ? !!this.noProviderPaging : true;
    },
    paginatedItems: function paginatedItems() {
      var items = this.sortedItems || this.filteredItems || this.localItems || [];
      var currentPage = Math.max(parseInt(this.currentPage, 10) || 1, 1);
      var perPage = Math.max(parseInt(this.perPage, 10) || 0, 0); // Apply local pagination

      if (this.localPaging && !!perPage) {
        // Grab the current page of data (which may be past filtered items limit)
        items = items.slice((currentPage - 1) * perPage, currentPage * perPage);
      } // Return the items to display in the table


      return items;
    }
  }
});

/***/ }),
/* 90 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__object__ = __webpack_require__(45);


var memoize = function memoize(fn) {
  var cache = Object(__WEBPACK_IMPORTED_MODULE_0__object__["a" /* create */])(null);
  return function () {
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    var argsKey = JSON.stringify(args);
    return cache[argsKey] = cache[argsKey] || fn.apply(null, args);
  };
};

/* harmony default export */ __webpack_exports__["a"] = (memoize);

/***/ }),
/* 91 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_get__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_to_string__ = __webpack_require__(76);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__tr__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__td__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__th__ = __webpack_require__(61);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }







var detailsSlotName = 'row-details';
/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    tbodyTrClass: {
      type: [String, Array, Function],
      default: null
    }
  },
  methods: {
    // Methods for computing classes, attributes and styles for table cells
    getTdValues: function getTdValues(item, key, tdValue, defValue) {
      var parent = this.$parent;

      if (tdValue) {
        var value = Object(__WEBPACK_IMPORTED_MODULE_0__utils_get__["a" /* default */])(item, key, '');

        if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(tdValue)) {
          return tdValue(value, key, item);
        } else if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["k" /* isString */])(tdValue) && Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(parent[tdValue])) {
          return parent[tdValue](value, key, item);
        }

        return tdValue;
      }

      return defValue;
    },
    getThValues: function getThValues(item, key, thValue, type, defValue) {
      var parent = this.$parent;

      if (thValue) {
        var value = Object(__WEBPACK_IMPORTED_MODULE_0__utils_get__["a" /* default */])(item, key, '');

        if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(thValue)) {
          return thValue(value, key, item, type);
        } else if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["k" /* isString */])(thValue) && Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(parent[thValue])) {
          return parent[thValue](value, key, item, type);
        }

        return thValue;
      }

      return defValue;
    },
    // Method to get the value for a field
    getFormattedValue: function getFormattedValue(item, field) {
      var key = field.key;
      var formatter = this.getFieldFormatter(key);
      var value = Object(__WEBPACK_IMPORTED_MODULE_0__utils_get__["a" /* default */])(item, key, null);

      if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(formatter)) {
        value = formatter(value, key, item);
      }

      return Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["m" /* isUndefinedOrNull */])(value) ? '' : value;
    },
    // Factory function methods
    toggleDetailsFactory: function toggleDetailsFactory(hasDetailsSlot, item) {
      var _this = this;

      // Returns a function to toggle a row's details slot
      return function () {
        if (hasDetailsSlot) {
          _this.$set(item, '_showDetails', !item._showDetails);
        }
      };
    },
    // Row event handlers
    rowHovered: function rowHovered(evt) {
      // `mouseenter` handler (non-bubbling)
      // `this.tbodyRowEvtStopped` from tbody mixin
      if (!this.tbodyRowEvtStopped(evt)) {
        // `this.emitTbodyRowEvent` from tbody mixin
        this.emitTbodyRowEvent('row-hovered', evt);
      }
    },
    rowUnhovered: function rowUnhovered(evt) {
      // `mouseleave` handler (non-bubbling)
      // `this.tbodyRowEvtStopped` from tbody mixin
      if (!this.tbodyRowEvtStopped(evt)) {
        // `this.emitTbodyRowEvent` from tbody mixin
        this.emitTbodyRowEvent('row-unhovered', evt);
      }
    },
    // Render helpers
    renderTbodyRowCell: function renderTbodyRowCell(field, colIndex, item, rowIndex) {
      // Renders a TD or TH for a row's field
      var h = this.$createElement;
      var hasDetailsSlot = this.hasNormalizedSlot(detailsSlotName);
      var formatted = this.getFormattedValue(item, field);
      var key = field.key; // We only uses the helper components for sticky columns to
      // improve performance of BTable/BTableLite by reducing the
      // total number of vue instances created during render

      var cellTag = field.stickyColumn ? field.isRowHeader ? __WEBPACK_IMPORTED_MODULE_5__th__["a" /* BTh */] : __WEBPACK_IMPORTED_MODULE_4__td__["a" /* BTd */] : field.isRowHeader ? 'th' : 'td';
      var cellVariant = item._cellVariants && item._cellVariants[key] ? item._cellVariants[key] : field.variant || null;
      var data = {
        // For the Vue key, we concatenate the column index and
        // field key (as field keys could be duplicated)
        // TODO: Although we do prevent duplicate field keys...
        //   So we could change this to: `row-${rowIndex}-cell-${key}`
        key: "row-".concat(rowIndex, "-cell-").concat(colIndex, "-").concat(key),
        class: [field.class ? field.class : '', this.getTdValues(item, key, field.tdClass, '')],
        props: {},
        attrs: _objectSpread({
          'aria-colindex': String(colIndex + 1)
        }, field.isRowHeader ? this.getThValues(item, key, field.thAttr, 'row', {}) : this.getTdValues(item, key, field.tdAttr, {}))
      };

      if (field.stickyColumn) {
        // We are using the helper BTd or BTh
        data.props = {
          stackedHeading: this.isStacked ? field.label : null,
          stickyColumn: field.stickyColumn,
          variant: cellVariant
        };
      } else {
        // Using native TD or TH element, so we need to
        // add in the attributes and variant class
        data.attrs['data-label'] = this.isStacked && !Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["m" /* isUndefinedOrNull */])(field.label) ? Object(__WEBPACK_IMPORTED_MODULE_1__utils_to_string__["a" /* default */])(field.label) : null;
        data.attrs.role = field.isRowHeader ? 'rowheader' : 'cell';
        data.attrs.scope = field.isRowHeader ? 'row' : null; // Add in the variant class

        if (cellVariant) {
          data.class.push("".concat(this.dark ? 'bg' : 'table', "-").concat(cellVariant));
        }
      }

      var slotScope = {
        item: item,
        index: rowIndex,
        field: field,
        unformatted: Object(__WEBPACK_IMPORTED_MODULE_0__utils_get__["a" /* default */])(item, key, ''),
        value: formatted,
        toggleDetails: this.toggleDetailsFactory(hasDetailsSlot, item),
        detailsShowing: Boolean(item._showDetails)
      };

      if (this.selectedRows) {
        // Add in rowSelected scope property if selectable rows supported
        slotScope.rowSelected = this.isRowSelected(rowIndex);
      } // The new `v-slot` syntax doesn't like a slot name starting with
      // a square bracket and if using in-document HTML templates, the
      // v-slot attributes are lower-cased by the browser.
      // Switched to round bracket syntax to prevent confusion with
      // dynamic slot name syntax.
      // We look for slots in this order: `cell(${key})`, `cell(${key.toLowerCase()})`, 'cell()'
      // Slot names are now cached by mixin tbody in `this.$_bodyFieldSlotNameCache`
      // Will be `null` if no slot (or fallback slot) exists


      var slotName = this.$_bodyFieldSlotNameCache[key];
      var $childNodes = slotName ? this.normalizeSlot(slotName, slotScope) : Object(__WEBPACK_IMPORTED_MODULE_1__utils_to_string__["a" /* default */])(formatted);

      if (this.isStacked) {
        // We wrap in a DIV to ensure rendered as a single cell when visually stacked!
        $childNodes = [h('div', {}, [$childNodes])];
      } // Render either a td or th cell


      return h(cellTag, data, [$childNodes]);
    },
    renderTbodyRow: function renderTbodyRow(item, rowIndex) {
      var _this2 = this;

      // Renders an item's row (or rows if details supported)
      var h = this.$createElement;
      var fields = this.computedFields;
      var tableStriped = this.striped;
      var hasDetailsSlot = this.hasNormalizedSlot(detailsSlotName);
      var rowShowDetails = Boolean(item._showDetails && hasDetailsSlot);
      var hasRowClickHandler = this.$listeners['row-clicked'] || this.isSelectable; // We can return more than one TR if rowDetails enabled

      var $rows = []; // Details ID needed for `aria-details` when details showing
      // We set it to `null` when not showing so that attribute
      // does not appear on the element

      var detailsId = rowShowDetails ? this.safeId("_details_".concat(rowIndex, "_")) : null; // For each item data field in row

      var $tds = fields.map(function (field, colIndex) {
        return _this2.renderTbodyRowCell(field, colIndex, item, rowIndex);
      }); // Calculate the row number in the dataset (indexed from 1)

      var ariaRowIndex = null;

      if (this.currentPage && this.perPage && this.perPage > 0) {
        ariaRowIndex = String((this.currentPage - 1) * this.perPage + rowIndex + 1);
      } // Create a unique :key to help ensure that sub components are re-rendered rather than
      // re-used, which can cause issues. If a primary key is not provided we use the rendered
      // rows index within the tbody.
      // See: https://github.com/bootstrap-vue/bootstrap-vue/issues/2410


      var primaryKey = this.primaryKey;
      var hasPkValue = primaryKey && !Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["m" /* isUndefinedOrNull */])(item[primaryKey]);
      var rowKey = hasPkValue ? Object(__WEBPACK_IMPORTED_MODULE_1__utils_to_string__["a" /* default */])(item[primaryKey]) : String(rowIndex); // If primary key is provided, use it to generate a unique ID on each tbody > tr
      // In the format of '{tableId}__row_{primaryKeyValue}'

      var rowId = hasPkValue ? this.safeId("_row_".concat(item[primaryKey])) : null; // Selectable classes and attributes

      var selectableClasses = this.selectableRowClasses ? this.selectableRowClasses(rowIndex) : {};
      var selectableAttrs = this.selectableRowAttrs ? this.selectableRowAttrs(rowIndex) : {}; // Add the item row

      $rows.push(h(__WEBPACK_IMPORTED_MODULE_3__tr__["a" /* BTr */], {
        key: "__b-table-row-".concat(rowKey, "__"),
        ref: 'itemRows',
        refInFor: true,
        class: [Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(this.tbodyTrClass) ? this.tbodyTrClass(item, 'row') : this.tbodyTrClass, selectableClasses, rowShowDetails ? 'b-table-has-details' : ''],
        props: {
          variant: item._rowVariant || null
        },
        attrs: _objectSpread({
          id: rowId,
          tabindex: hasRowClickHandler ? '0' : null,
          'data-pk': rowId ? String(item[primaryKey]) : null,
          // Should this be `aria-details` instead?
          'aria-details': detailsId,
          'aria-owns': detailsId,
          'aria-rowindex': ariaRowIndex
        }, selectableAttrs),
        on: {
          // Note: These events are not A11Y friendly!
          mouseenter: this.rowHovered,
          mouseleave: this.rowUnhovered
        }
      }, $tds)); // Row Details slot

      if (rowShowDetails) {
        var detailsScope = {
          item: item,
          index: rowIndex,
          fields: fields,
          toggleDetails: this.toggleDetailsFactory(hasDetailsSlot, item)
        }; // Render the details slot in a TD

        var $details = h(__WEBPACK_IMPORTED_MODULE_4__td__["a" /* BTd */], {
          props: {
            colspan: fields.length
          }
        }, [this.normalizeSlot(detailsSlotName, detailsScope)]); // Add a hidden row to keep table row striping consistent when details showing

        if (tableStriped) {
          $rows.push( // We don't use `BTr` here as we dont need the extra functionality
          h('tr', {
            key: "__b-table-details-stripe__".concat(rowKey),
            staticClass: 'd-none',
            attrs: {
              'aria-hidden': 'true',
              role: 'presentation'
            }
          }));
        } // Add the actual details row


        $rows.push(h(__WEBPACK_IMPORTED_MODULE_3__tr__["a" /* BTr */], {
          key: "__b-table-details__".concat(rowKey),
          staticClass: 'b-table-details',
          class: [Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(this.tbodyTrClass) ? this.tbodyTrClass(item, detailsSlotName) : this.tbodyTrClass],
          props: {
            variant: item._rowVariant || null
          },
          attrs: {
            id: detailsId,
            tabindex: '-1'
          }
        }, [$details]));
      } else if (hasDetailsSlot) {
        // Only add the placeholder if a the table has a row-details slot defined (but not shown)
        $rows.push(h());

        if (tableStriped) {
          // Add extra placeholder if table is striped
          $rows.push(h());
        }
      } // Return the row(s)


      return $rows;
    }
  }
});

/***/ }),
/* 92 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_html__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__tr__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__td__ = __webpack_require__(48);




/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    showEmpty: {
      type: Boolean,
      default: false
    },
    emptyText: {
      type: String,
      default: 'There are no records to show'
    },
    emptyHtml: {
      type: String
    },
    emptyFilteredText: {
      type: String,
      default: 'There are no records matching your request'
    },
    emptyFilteredHtml: {
      type: String
    }
  },
  methods: {
    renderEmpty: function renderEmpty() {
      var h = this.$createElement;
      var items = this.computedItems;
      var $empty;

      if (this.showEmpty && (!items || items.length === 0) && !(this.computedBusy && this.hasNormalizedSlot('table-busy'))) {
        $empty = this.normalizeSlot(this.isFiltered ? 'emptyfiltered' : 'empty', {
          emptyFilteredHtml: this.emptyFilteredHtml,
          emptyFilteredText: this.emptyFilteredText,
          emptyHtml: this.emptyHtml,
          emptyText: this.emptyText,
          fields: this.computedFields,
          // Not sure why this is included, as it will always be an empty array
          items: this.computedItems
        });

        if (!$empty) {
          $empty = h('div', {
            class: ['text-center', 'my-2'],
            domProps: this.isFiltered ? Object(__WEBPACK_IMPORTED_MODULE_0__utils_html__["a" /* htmlOrText */])(this.emptyFilteredHtml, this.emptyFilteredText) : Object(__WEBPACK_IMPORTED_MODULE_0__utils_html__["a" /* htmlOrText */])(this.emptyHtml, this.emptyText)
          });
        }

        $empty = h(__WEBPACK_IMPORTED_MODULE_3__td__["a" /* BTd */], {
          props: {
            colspan: this.computedFields.length || null
          }
        }, [h('div', {
          attrs: {
            role: 'alert',
            'aria-live': 'polite'
          }
        }, [$empty])]);
        $empty = h(__WEBPACK_IMPORTED_MODULE_2__tr__["a" /* BTr */], {
          key: this.isFiltered ? 'b-empty-filtered-row' : 'b-empty-row',
          staticClass: 'b-table-empty-row',
          class: [Object(__WEBPACK_IMPORTED_MODULE_1__utils_inspect__["d" /* isFunction */])(this.tbodyTrClass) ? this.tbodyTrClass(null, 'row-empty') : this.tbodyTrClass]
        }, [$empty]);
      }

      return $empty || h();
    }
  }
});

/***/ }),
/* 93 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__tr__ = __webpack_require__(47);


var slotName = 'top-row';
/* harmony default export */ __webpack_exports__["a"] = ({
  methods: {
    renderTopRow: function renderTopRow() {
      var h = this.$createElement; // Add static Top Row slot (hidden in visibly stacked mode as we can't control the data-label)
      // If in *always* stacked mode, we don't bother rendering the row

      if (!this.hasNormalizedSlot(slotName) || this.stacked === true || this.stacked === '') {
        return h();
      }

      var fields = this.computedFields;
      return h(__WEBPACK_IMPORTED_MODULE_1__tr__["a" /* BTr */], {
        key: 'b-top-row',
        staticClass: 'b-table-top-row',
        class: [Object(__WEBPACK_IMPORTED_MODULE_0__utils_inspect__["d" /* isFunction */])(this.tbodyTrClass) ? this.tbodyTrClass(null, 'row-top') : this.tbodyTrClass]
      }, [this.normalizeSlot(slotName, {
        columns: fields.length,
        fields: fields
      })]);
    }
  }
});

/***/ }),
/* 94 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__tr__ = __webpack_require__(47);


var slotName = 'bottom-row';
/* harmony default export */ __webpack_exports__["a"] = ({
  methods: {
    renderBottomRow: function renderBottomRow() {
      var h = this.$createElement; // Static bottom row slot (hidden in visibly stacked mode as we can't control the data-label)
      // If in *always* stacked mode, we don't bother rendering the row

      if (!this.hasNormalizedSlot(slotName) || this.stacked === true || this.stacked === '') {
        return h();
      }

      var fields = this.computedFields;
      return h(__WEBPACK_IMPORTED_MODULE_1__tr__["a" /* BTr */], {
        key: 'b-bottom-row',
        staticClass: 'b-table-bottom-row',
        class: [Object(__WEBPACK_IMPORTED_MODULE_0__utils_inspect__["d" /* isFunction */])(this.tbodyTrClass) ? this.tbodyTrClass(null, 'row-bottom') : this.tbodyTrClass]
      }, this.normalizeSlot(slotName, {
        columns: fields.length,
        fields: fields
      }));
    }
  }
});

/***/ }),
/* 95 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__tr__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__td__ = __webpack_require__(48);



var busySlotName = 'table-busy';
/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    busy: {
      type: Boolean,
      default: false
    }
  },
  data: function data() {
    return {
      localBusy: false
    };
  },
  computed: {
    computedBusy: function computedBusy() {
      return this.busy || this.localBusy;
    }
  },
  watch: {
    localBusy: function localBusy(newVal, oldVal) {
      if (newVal !== oldVal) {
        this.$emit('update:busy', newVal);
      }
    }
  },
  methods: {
    // Event handler helper
    stopIfBusy: function stopIfBusy(evt) {
      if (this.computedBusy) {
        // If table is busy (via provider) then don't propagate
        evt.preventDefault();
        evt.stopPropagation();
        return true;
      }

      return false;
    },
    // Render the busy indicator or return `null` if not busy
    renderBusy: function renderBusy() {
      var h = this.$createElement; // Return a busy indicator row, or `null` if not busy

      if (this.computedBusy && this.hasNormalizedSlot(busySlotName)) {
        // Show the busy slot
        return h(__WEBPACK_IMPORTED_MODULE_1__tr__["a" /* BTr */], {
          key: 'table-busy-slot',
          staticClass: 'b-table-busy-slot',
          class: [Object(__WEBPACK_IMPORTED_MODULE_0__utils_inspect__["d" /* isFunction */])(this.tbodyTrClass) ? this.tbodyTrClass(null, busySlotName) : this.tbodyTrClass]
        }, [h(__WEBPACK_IMPORTED_MODULE_2__td__["a" /* BTd */], {
          props: {
            colspan: this.computedFields.length || null
          }
        }, [this.normalizeSlot(busySlotName)])]);
      } else {
        // We return `null` here so that we can determine if we need to
        // render the table items rows or not
        return null;
      }
    }
  }
});

/***/ }),
/* 96 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_range__ = __webpack_require__(97);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_array__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__utils_config__ = __webpack_require__(58);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__sanitize_row__ = __webpack_require__(66);
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }







/* harmony default export */ __webpack_exports__["a"] = ({
  props: {
    selectable: {
      type: Boolean,
      default: false
    },
    selectMode: {
      type: String,
      default: 'multi',
      validator: function validator(val) {
        return Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["a" /* arrayIncludes */])(['range', 'multi', 'single'], val);
      }
    },
    selectedVariant: {
      type: String,
      default: function _default() {
        return Object(__WEBPACK_IMPORTED_MODULE_3__utils_config__["a" /* getComponentConfig */])('BTable', 'selectedVariant');
      }
    }
  },
  data: function data() {
    return {
      selectedRows: [],
      selectedLastRow: -1
    };
  },
  computed: {
    isSelectable: function isSelectable() {
      return this.selectable && this.selectMode;
    },
    selectableHasSelection: function selectableHasSelection() {
      return this.isSelectable && this.selectedRows && this.selectedRows.length > 0 && this.selectedRows.some(Boolean);
    },
    selectableIsMultiSelect: function selectableIsMultiSelect() {
      return this.isSelectable && Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["a" /* arrayIncludes */])(['range', 'multi'], this.selectMode);
    },
    selectableTableClasses: function selectableTableClasses() {
      var _ref;

      return _ref = {
        'b-table-selectable': this.isSelectable
      }, _defineProperty(_ref, "b-table-select-".concat(this.selectMode), this.isSelectable), _defineProperty(_ref, 'b-table-selecting', this.selectableHasSelection), _ref;
    },
    selectableTableAttrs: function selectableTableAttrs() {
      return {
        'aria-multiselectable': !this.isSelectable ? null : this.selectableIsMultiSelect ? 'true' : 'false'
      };
    }
  },
  watch: {
    computedItems: function computedItems(newVal, oldVal) {
      // Reset for selectable
      var equal = false;

      if (this.isSelectable && this.selectedRows.length > 0) {
        // Quick check against array length
        equal = Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["d" /* isArray */])(newVal) && Object(__WEBPACK_IMPORTED_MODULE_2__utils_array__["d" /* isArray */])(oldVal) && newVal.length === oldVal.length;

        for (var i = 0; equal && i < newVal.length; i++) {
          // Look for the first non-loosely equal row, after ignoring reserved fields
          equal = Object(__WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__["a" /* default */])(Object(__WEBPACK_IMPORTED_MODULE_5__sanitize_row__["a" /* default */])(newVal[i]), Object(__WEBPACK_IMPORTED_MODULE_5__sanitize_row__["a" /* default */])(oldVal[i]));
        }
      }

      if (!equal) {
        this.clearSelected();
      }
    },
    selectable: function selectable(newVal, oldVal) {
      this.clearSelected();
      this.setSelectionHandlers(newVal);
    },
    selectMode: function selectMode(newVal, oldVal) {
      this.clearSelected();
    },
    selectedRows: function selectedRows(_selectedRows, oldVal) {
      var _this = this;

      if (this.isSelectable && !Object(__WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__["a" /* default */])(_selectedRows, oldVal)) {
        var items = []; // `.forEach()` skips over non-existent indices (on sparse arrays)

        _selectedRows.forEach(function (v, idx) {
          if (v) {
            items.push(_this.computedItems[idx]);
          }
        });

        this.$emit('row-selected', items);
      }
    }
  },
  beforeMount: function beforeMount() {
    // Set up handlers
    if (this.isSelectable) {
      this.setSelectionHandlers(true);
    }
  },
  methods: {
    // Public methods
    selectRow: function selectRow(index) {
      // Select a particular row (indexed based on computedItems)
      if (this.isSelectable && Object(__WEBPACK_IMPORTED_MODULE_4__utils_inspect__["f" /* isNumber */])(index) && index >= 0 && index < this.computedItems.length && !this.isRowSelected(index)) {
        var selectedRows = this.selectableIsMultiSelect ? this.selectedRows.slice() : [];
        selectedRows[index] = true;
        this.selectedLastClicked = -1;
        this.selectedRows = selectedRows;
      }
    },
    unselectRow: function unselectRow(index) {
      // Un-select a particular row (indexed based on `computedItems`)
      if (this.isSelectable && Object(__WEBPACK_IMPORTED_MODULE_4__utils_inspect__["f" /* isNumber */])(index) && this.isRowSelected(index)) {
        var selectedRows = this.selectedRows.slice();
        selectedRows[index] = false;
        this.selectedLastClicked = -1;
        this.selectedRows = selectedRows;
      }
    },
    selectAllRows: function selectAllRows() {
      var length = this.computedItems.length;

      if (this.isSelectable && length > 0) {
        this.selectedLastClicked = -1;
        this.selectedRows = this.selectableIsMultiSelect ? Object(__WEBPACK_IMPORTED_MODULE_1__utils_range__["a" /* default */])(length).map(function (i) {
          return true;
        }) : [true];
      }
    },
    isRowSelected: function isRowSelected(index) {
      // Determine if a row is selected (indexed based on `computedItems`)
      return Boolean(Object(__WEBPACK_IMPORTED_MODULE_4__utils_inspect__["f" /* isNumber */])(index) && this.selectedRows[index]);
    },
    clearSelected: function clearSelected() {
      // Clear any active selected row(s)
      this.selectedLastClicked = -1;
      this.selectedRows = [];
    },
    // Internal private methods
    selectableRowClasses: function selectableRowClasses(index) {
      if (this.isSelectable && this.isRowSelected(index)) {
        var variant = this.selectedVariant;
        return _defineProperty({
          'b-table-row-selected': true
        }, "".concat(this.dark ? 'bg' : 'table', "-").concat(variant), variant);
      } else {
        return {};
      }
    },
    selectableRowAttrs: function selectableRowAttrs(index) {
      return {
        'aria-selected': !this.isSelectable ? null : this.isRowSelected(index) ? 'true' : 'false'
      };
    },
    setSelectionHandlers: function setSelectionHandlers(on) {
      var method = on ? '$on' : '$off'; // Handle row-clicked event

      this[method]('row-clicked', this.selectionHandler); // Clear selection on filter, pagination, and sort changes

      this[method]('filtered', this.clearSelected);
      this[method]('context-changed', this.clearSelected);
    },
    selectionHandler: function selectionHandler(item, index, evt) {
      /* istanbul ignore if: should never happen */
      if (!this.isSelectable) {
        // Don't do anything if table is not in selectable mode

        /* istanbul ignore next: should never happen */
        this.clearSelected();
        /* istanbul ignore next: should never happen */

        return;
      }

      var selectMode = this.selectMode;
      var selectedRows = this.selectedRows.slice();
      var selected = !selectedRows[index]; // Note 'multi' mode needs no special event handling

      if (selectMode === 'single') {
        selectedRows = [];
      } else if (selectMode === 'range') {
        if (this.selectedLastRow > -1 && evt.shiftKey) {
          // range
          for (var idx = Math.min(this.selectedLastRow, index); idx <= Math.max(this.selectedLastRow, index); idx++) {
            selectedRows[idx] = true;
          }

          selected = true;
        } else {
          if (!(evt.ctrlKey || evt.metaKey)) {
            // Clear range selection if any
            selectedRows = [];
            selected = true;
          }

          this.selectedLastRow = selected ? index : -1;
        }
      }

      selectedRows[index] = selected;
      this.selectedRows = selectedRows;
    }
  }
});

/***/ }),
/* 97 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * @param {number} length
 * @return {Array}
 */
var range = function range(length) {
  return Array.apply(null, {
    length: length
  });
};

/* harmony default export */ __webpack_exports__["a"] = (range);

/***/ }),
/* 98 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__utils_warn__ = __webpack_require__(62);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__utils_inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__mixins_listen_on_root__ = __webpack_require__(99);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }





/* harmony default export */ __webpack_exports__["a"] = ({
  mixins: [__WEBPACK_IMPORTED_MODULE_3__mixins_listen_on_root__["a" /* default */]],
  props: {
    // Prop override(s)
    items: {
      // Adds in 'Function' support
      type: [Array, Function],
      default: function _default()
      /* istanbul ignore next */
      {
        return [];
      }
    },
    // Additional props
    noProviderPaging: {
      type: Boolean,
      default: false
    },
    noProviderSorting: {
      type: Boolean,
      default: false
    },
    noProviderFiltering: {
      type: Boolean,
      default: false
    },
    apiUrl: {
      // Passthrough prop. Passed to the context object. Not used by b-table directly
      type: String,
      default: ''
    }
  },
  computed: {
    hasProvider: function hasProvider() {
      return Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(this.items);
    },
    providerTriggerContext: function providerTriggerContext() {
      // Used to trigger the provider function via a watcher. Only the fields that
      // are needed for triggering a provider update are included. Note that the
      // regular this.context is sent to the provider during fetches though, as they
      // may need all the prop info.
      var ctx = {
        apiUrl: this.apiUrl,
        filter: null,
        sortBy: null,
        sortDesc: null,
        perPage: null,
        currentPage: null
      };

      if (!this.noProviderFiltering) {
        // Either a string, or could be an object or array.
        ctx.filter = this.localFilter;
      }

      if (!this.noProviderSorting) {
        ctx.sortBy = this.localSortBy;
        ctx.sortDesc = this.localSortDesc;
      }

      if (!this.noProviderPaging) {
        ctx.perPage = this.perPage;
        ctx.currentPage = this.currentPage;
      }

      return _objectSpread({}, ctx);
    }
  },
  watch: {
    // Provider update triggering
    items: function items(newVal, oldVal) {
      // If a new provider has been specified, trigger an update
      if (this.hasProvider || Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["d" /* isFunction */])(newVal)) {
        this.$nextTick(this._providerUpdate);
      }
    },
    providerTriggerContext: function providerTriggerContext(newVal, oldVal) {
      // Trigger the provider to update as the relevant context values have changed.
      if (!Object(__WEBPACK_IMPORTED_MODULE_0__utils_loose_equal__["a" /* default */])(newVal, oldVal)) {
        this.$nextTick(this._providerUpdate);
      }
    }
  },
  mounted: function mounted() {
    var _this = this;

    // Call the items provider if necessary
    if (this.hasProvider && (!this.localItems || this.localItems.length === 0)) {
      // Fetch on mount if localItems is empty
      this._providerUpdate();
    } // Listen for global messages to tell us to force refresh the table


    this.listenOnRoot('bv::refresh::table', function (id) {
      if (id === _this.id || id === _this) {
        _this.refresh();
      }
    });
  },
  methods: {
    refresh: function refresh() {
      // Public Method: Force a refresh of the provider function
      this.$off('refreshed', this.refresh);

      if (this.computedBusy) {
        // Can't force an update when forced busy by user (busy prop === true)
        if (this.localBusy && this.hasProvider) {
          // But if provider running (localBusy), re-schedule refresh once `refreshed` emitted
          this.$on('refreshed', this.refresh);
        }
      } else {
        this.clearSelected();

        if (this.hasProvider) {
          this.$nextTick(this._providerUpdate);
        } else {
          /* istanbul ignore next */
          this.localItems = Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["a" /* isArray */])(this.items) ? this.items.slice() : [];
        }
      }
    },
    // Provider related methods
    _providerSetLocal: function _providerSetLocal(items) {
      this.localItems = Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["a" /* isArray */])(items) ? items.slice() : [];
      this.localBusy = false;
      this.$emit('refreshed'); // New root emit

      if (this.id) {
        this.emitOnRoot('bv::table::refreshed', this.id);
      }
    },
    _providerUpdate: function _providerUpdate() {
      var _this2 = this;

      // Refresh the provider function items.
      if (!this.hasProvider) {
        // Do nothing if no provider
        return;
      } // If table is busy, wait until refreshed before calling again


      if (this.computedBusy) {
        // Schedule a new refresh once `refreshed` is emitted
        this.$nextTick(this.refresh);
        return;
      } // Set internal busy state


      this.localBusy = true; // Call provider function with context and optional callback after DOM is fully updated

      this.$nextTick(function () {
        try {
          // Call provider function passing it the context and optional callback
          var data = _this2.items(_this2.context, _this2._providerSetLocal);

          if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["i" /* isPromise */])(data)) {
            // Provider returned Promise
            data.then(function (items) {
              // Provider resolved with items
              _this2._providerSetLocal(items);
            });
          } else if (Object(__WEBPACK_IMPORTED_MODULE_2__utils_inspect__["a" /* isArray */])(data)) {
            // Provider returned Array data
            _this2._providerSetLocal(data);
          } else {
            /* istanbul ignore if */
            if (_this2.items.length !== 2) {
              // Check number of arguments provider function requested
              // Provider not using callback (didn't request second argument), so we clear
              // busy state as most likely there was an error in the provider function

              /* istanbul ignore next */
              Object(__WEBPACK_IMPORTED_MODULE_1__utils_warn__["a" /* default */])("b-table provider function didn't request callback and did not return a promise or data");
              _this2.localBusy = false;
            }
          }
        } catch (e)
        /* istanbul ignore next */
        {
          // Provider function borked on us, so we spew out a warning
          // and clear the busy state
          Object(__WEBPACK_IMPORTED_MODULE_1__utils_warn__["a" /* default */])("b-table provider function error [".concat(e.name, "] ").concat(e.message));
          _this2.localBusy = false;

          _this2.$off('refreshed', _this2.refresh);
        }
      });
    }
  }
});

/***/ }),
/* 99 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/**
 * Issue #569: collapse::toggle::state triggered too many times
 * @link https://github.com/bootstrap-vue/bootstrap-vue/issues/569
 */
// @vue/component
/* harmony default export */ __webpack_exports__["a"] = ({
  methods: {
    /**
     * Safely register event listeners on the root Vue node.
     * While Vue automatically removes listeners for individual components,
     * when a component registers a listener on root and is destroyed,
     * this orphans a callback because the node is gone,
     * but the root does not clear the callback.
     *
     * When registering a $root listener, it also registers a listener on
     * the component's `beforeDestroy` hook to automatically remove the
     * event listener from the $root instance.
     *
     * @param {string} event
     * @param {function} callback
     * @chainable
     */
    listenOnRoot: function listenOnRoot(event, callback) {
      var _this = this;

      this.$root.$on(event, callback);
      this.$on('hook:beforeDestroy', function () {
        _this.$root.$off(event, callback);
      }); // Return this for easy chaining

      return this;
    },

    /**
     * Safely register a $once event listener on the root Vue node.
     * While Vue automatically removes listeners for individual components,
     * when a component registers a listener on root and is destroyed,
     * this orphans a callback because the node is gone,
     * but the root does not clear the callback.
     *
     * When registering a $root listener, it also registers a listener on
     * the component's `beforeDestroy` hook to automatically remove the
     * event listener from the $root instance.
     *
     * @param {string} event
     * @param {function} callback
     * @chainable
     */
    listenOnRootOnce: function listenOnRootOnce(event, callback) {
      var _this2 = this;

      this.$root.$once(event, callback);
      this.$on('hook:beforeDestroy', function () {
        _this2.$root.$off(event, callback);
      }); // Return this for easy chaining

      return this;
    },

    /**
     * Convenience method for calling vm.$emit on vm.$root.
     * @param {string} event
     * @param {*} args
     * @chainable
     */
    emitOnRoot: function emitOnRoot(event) {
      var _this$$root;

      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }

      (_this$$root = this.$root).$emit.apply(_this$$root, [event].concat(args)); // Return this for easy chaining


      return this;
    }
  }
});

/***/ }),
/* 100 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTableLite; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_id__ = __webpack_require__(52);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mixins_normalize_slot__ = __webpack_require__(46);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__helpers_mixin_items__ = __webpack_require__(65);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_caption__ = __webpack_require__(68);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__helpers_mixin_colgroup__ = __webpack_require__(69);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__helpers_mixin_stacked__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__helpers_mixin_thead__ = __webpack_require__(70);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__helpers_mixin_tfoot__ = __webpack_require__(77);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__helpers_mixin_tbody__ = __webpack_require__(78);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__helpers_mixin_table_renderer__ = __webpack_require__(63);
 // Mixins


 // Table helper Mixins







 // Main table renderer mixin

 // b-table-lite component definition
// @vue/component

var BTableLite =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTableLite',
  // Order of mixins is important!
  // They are merged from first to last, followed by this component.
  mixins: [// Required mixins
  __WEBPACK_IMPORTED_MODULE_1__mixins_id__["a" /* default */], __WEBPACK_IMPORTED_MODULE_2__mixins_normalize_slot__["a" /* default */], __WEBPACK_IMPORTED_MODULE_3__helpers_mixin_items__["a" /* default */], __WEBPACK_IMPORTED_MODULE_10__helpers_mixin_table_renderer__["a" /* default */], __WEBPACK_IMPORTED_MODULE_6__helpers_mixin_stacked__["a" /* default */], __WEBPACK_IMPORTED_MODULE_7__helpers_mixin_thead__["a" /* default */], __WEBPACK_IMPORTED_MODULE_8__helpers_mixin_tfoot__["a" /* default */], __WEBPACK_IMPORTED_MODULE_9__helpers_mixin_tbody__["a" /* default */], // Features Mixins
  // These are pretty lightweight, and are useful for lightweight tables
  __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_caption__["a" /* default */], __WEBPACK_IMPORTED_MODULE_5__helpers_mixin_colgroup__["a" /* default */]] // render function provided by table-renderer mixin

});

/***/ }),
/* 101 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return BTableSimple; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__mixins_id__ = __webpack_require__(52);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mixins_normalize_slot__ = __webpack_require__(46);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__helpers_mixin_table_renderer__ = __webpack_require__(63);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_stacked__ = __webpack_require__(55);
 // Mixins


 // Main table renderer mixin

 // Feature miins

 // b-table-simple component definition
// @vue/component

var BTableSimple =
/*#__PURE__*/
__WEBPACK_IMPORTED_MODULE_0__utils_vue__["a" /* default */].extend({
  name: 'BTableSimple',
  // Order of mixins is important!
  // They are merged from first to last, followed by this component.
  mixins: [// Required mixins
  __WEBPACK_IMPORTED_MODULE_1__mixins_id__["a" /* default */], __WEBPACK_IMPORTED_MODULE_2__mixins_normalize_slot__["a" /* default */], __WEBPACK_IMPORTED_MODULE_3__helpers_mixin_table_renderer__["a" /* default */], // feature mixin
  // Stacked requires extra handling by users via
  // the table cell `stacked-heading` prop
  __WEBPACK_IMPORTED_MODULE_4__helpers_mixin_stacked__["a" /* default */]],
  computed: {
    isTableSimple: function isTableSimple() {
      return true;
    }
  } // render function provided by table-renderer mixin

});

/***/ }),
/* 102 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export checkMultipleVue */
/* unused harmony export installFactory */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return pluginFactory; });
/* unused harmony export registerPlugins */
/* unused harmony export registerComponent */
/* unused harmony export registerComponents */
/* unused harmony export registerDirective */
/* unused harmony export registerDirectives */
/* unused harmony export vueUse */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__warn__ = __webpack_require__(62);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__config_set__ = __webpack_require__(103);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__env__ = __webpack_require__(49);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }





/**
 * Checks if there are multiple instances of Vue, and warns (once) about possible issues.
 * @param {object} Vue
 */

var checkMultipleVue = function () {
  var checkMultipleVueWarned = false;
  var MULTIPLE_VUE_WARNING = ['Multiple instances of Vue detected!', 'You may need to set up an alias for Vue in your bundler config.', 'See: https://bootstrap-vue.js.org/docs#using-module-bundlers'].join('\n');
  return function (Vue) {
    /* istanbul ignore next */
    if (!checkMultipleVueWarned && __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */] !== Vue && !__WEBPACK_IMPORTED_MODULE_3__env__["h" /* isJSDOM */]) {
      Object(__WEBPACK_IMPORTED_MODULE_1__warn__["a" /* default */])(MULTIPLE_VUE_WARNING);
    }

    checkMultipleVueWarned = true;
  };
}();
/**
 * Plugin install factory function.
 * @param {object} { components, directives }
 * @returns {function} plugin install function
 */

var installFactory = function installFactory() {
  var _ref = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {},
      components = _ref.components,
      directives = _ref.directives,
      plugins = _ref.plugins;

  var install = function install(Vue) {
    var config = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    if (install.installed) {
      /* istanbul ignore next */
      return;
    }

    install.installed = true;
    checkMultipleVue(Vue);
    Object(__WEBPACK_IMPORTED_MODULE_2__config_set__["a" /* setConfig */])(config, Vue);
    registerComponents(Vue, components);
    registerDirectives(Vue, directives);
    registerPlugins(Vue, plugins);
  };

  install.installed = false;
  return install;
};
/**
 * Plugin object factory function.
 * @param {object} { components, directives, plugins }
 * @returns {object} plugin install object
 */

var pluginFactory = function pluginFactory() {
  var opts = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var extend = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
  return _objectSpread({}, extend, {
    install: installFactory(opts)
  });
};
/**
 * Load a group of plugins.
 * @param {object} Vue
 * @param {object} Plugin definitions
 */

var registerPlugins = function registerPlugins(Vue) {
  var plugins = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  for (var plugin in plugins) {
    if (plugin && plugins[plugin]) {
      Vue.use(plugins[plugin]);
    }
  }
};
/**
 * Load a component.
 * @param {object} Vue
 * @param {string} Component name
 * @param {object} Component definition
 */

var registerComponent = function registerComponent(Vue, name, def) {
  if (Vue && name && def) {
    Vue.component(name, def);
  }
};
/**
 * Load a group of components.
 * @param {object} Vue
 * @param {object} Object of component definitions
 */

var registerComponents = function registerComponents(Vue) {
  var components = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  for (var component in components) {
    registerComponent(Vue, component, components[component]);
  }
};
/**
 * Load a directive.
 * @param {object} Vue
 * @param {string} Directive name
 * @param {object} Directive definition
 */

var registerDirective = function registerDirective(Vue, name, def) {
  if (Vue && name && def) {
    // Ensure that any leading V is removed from the
    // name, as Vue adds it automatically
    Vue.directive(name.replace(/^VB/, 'B'), def);
  }
};
/**
 * Load a group of directives.
 * @param {object} Vue
 * @param {object} Object of directive definitions
 */

var registerDirectives = function registerDirectives(Vue) {
  var directives = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

  for (var directive in directives) {
    registerDirective(Vue, directive, directives[directive]);
  }
};
/**
 * Install plugin if window.Vue available
 * @param {object} Plugin definition
 */

var vueUse = function vueUse(VuePlugin) {
  /* istanbul ignore next */
  if (__WEBPACK_IMPORTED_MODULE_3__env__["f" /* hasWindowSupport */] && window.Vue) {
    window.Vue.use(VuePlugin);
  }
  /* istanbul ignore next */


  if (__WEBPACK_IMPORTED_MODULE_3__env__["f" /* hasWindowSupport */] && VuePlugin.NAME) {
    window[VuePlugin.NAME] = VuePlugin;
  }
};

/***/ }),
/* 103 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return setConfig; });
/* unused harmony export resetConfig */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__vue__ = __webpack_require__(43);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__clone_deep__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__get__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__warn__ = __webpack_require__(62);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__inspect__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__object__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__config_defaults__ = __webpack_require__(72);
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }







 // --- Constants ---

var PROP_NAME = '$bvConfig'; // Config manager class

var BvConfig =
/*#__PURE__*/
function () {
  function BvConfig() {
    _classCallCheck(this, BvConfig);

    // TODO: pre-populate with default config values (needs updated tests)
    // this.$_config = cloneDeep(DEFAULTS)
    this.$_config = {};
    this.$_cachedBreakpoints = null;
  }

  _createClass(BvConfig, [{
    key: "getDefaults",
    // Returns the defaults
    value: function getDefaults()
    /* istanbul ignore next */
    {
      return this.defaults;
    } // Method to merge in user config parameters

  }, {
    key: "setConfig",
    value: function setConfig() {
      var _this = this;

      var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

      if (!Object(__WEBPACK_IMPORTED_MODULE_4__inspect__["h" /* isPlainObject */])(config)) {
        /* istanbul ignore next */
        return;
      }

      var configKeys = Object(__WEBPACK_IMPORTED_MODULE_5__object__["c" /* getOwnPropertyNames */])(config);
      configKeys.forEach(function (cmpName) {
        /* istanbul ignore next */
        if (!Object(__WEBPACK_IMPORTED_MODULE_5__object__["d" /* hasOwnProperty */])(__WEBPACK_IMPORTED_MODULE_6__config_defaults__["a" /* default */], cmpName)) {
          Object(__WEBPACK_IMPORTED_MODULE_3__warn__["a" /* default */])("config: unknown config property \"".concat(cmpName, "\""));
          return;
        }

        var cmpConfig = config[cmpName];

        if (cmpName === 'breakpoints') {
          // Special case for breakpoints
          var breakpoints = config.breakpoints;
          /* istanbul ignore if */

          if (!Object(__WEBPACK_IMPORTED_MODULE_4__inspect__["a" /* isArray */])(breakpoints) || breakpoints.length < 2 || breakpoints.some(function (b) {
            return !Object(__WEBPACK_IMPORTED_MODULE_4__inspect__["k" /* isString */])(b) || b.length === 0;
          })) {
            Object(__WEBPACK_IMPORTED_MODULE_3__warn__["a" /* default */])('config: "breakpoints" must be an array of at least 2 breakpoint names');
          } else {
            _this.$_config.breakpoints = Object(__WEBPACK_IMPORTED_MODULE_1__clone_deep__["a" /* default */])(breakpoints);
          }
        } else if (Object(__WEBPACK_IMPORTED_MODULE_4__inspect__["h" /* isPlainObject */])(cmpConfig)) {
          // Component prop defaults
          var props = Object(__WEBPACK_IMPORTED_MODULE_5__object__["c" /* getOwnPropertyNames */])(cmpConfig);
          props.forEach(function (prop) {
            /* istanbul ignore if */
            if (!Object(__WEBPACK_IMPORTED_MODULE_5__object__["d" /* hasOwnProperty */])(__WEBPACK_IMPORTED_MODULE_6__config_defaults__["a" /* default */][cmpName], prop)) {
              Object(__WEBPACK_IMPORTED_MODULE_3__warn__["a" /* default */])("config: unknown config property \"".concat(cmpName, ".").concat(prop, "\""));
            } else {
              // TODO: If we pre-populate the config with defaults, we can skip this line
              _this.$_config[cmpName] = _this.$_config[cmpName] || {};

              if (!Object(__WEBPACK_IMPORTED_MODULE_4__inspect__["l" /* isUndefined */])(cmpConfig[prop])) {
                _this.$_config[cmpName][prop] = Object(__WEBPACK_IMPORTED_MODULE_1__clone_deep__["a" /* default */])(cmpConfig[prop]);
              }
            }
          });
        }
      });
    } // Clear the config. For testing purposes only

  }, {
    key: "resetConfig",
    value: function resetConfig() {
      this.$_config = {};
    } // Returns a deep copy of the user config

  }, {
    key: "getConfig",
    value: function getConfig() {
      return Object(__WEBPACK_IMPORTED_MODULE_1__clone_deep__["a" /* default */])(this.$_config);
    }
  }, {
    key: "getConfigValue",
    value: function getConfigValue(key) {
      // First we try the user config, and if key not found we fall back to default value
      // NOTE: If we deep clone DEFAULTS into config, then we can skip the fallback for get
      return Object(__WEBPACK_IMPORTED_MODULE_1__clone_deep__["a" /* default */])(Object(__WEBPACK_IMPORTED_MODULE_2__get__["a" /* default */])(this.$_config, key, Object(__WEBPACK_IMPORTED_MODULE_2__get__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_6__config_defaults__["a" /* default */], key)));
    }
  }, {
    key: "defaults",
    get: function get()
    /* istanbul ignore next */
    {
      return __WEBPACK_IMPORTED_MODULE_6__config_defaults__["a" /* default */];
    }
  }], [{
    key: "Defaults",
    get: function get()
    /* istanbul ignore next */
    {
      return __WEBPACK_IMPORTED_MODULE_6__config_defaults__["a" /* default */];
    }
  }]);

  return BvConfig;
}(); // Method for applying a global config


var setConfig = function setConfig() {
  var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var Vue = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */];
  // Ensure we have a $bvConfig Object on the Vue prototype.
  // We set on Vue and OurVue just in case consumer has not set an alias of `vue`.
  Vue.prototype[PROP_NAME] = __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */].prototype[PROP_NAME] = Vue.prototype[PROP_NAME] || __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */].prototype[PROP_NAME] || new BvConfig(); // Apply the config values

  Vue.prototype[PROP_NAME].setConfig(config);
}; // Method for resetting the user config. Exported for testing purposes only.

var resetConfig = function resetConfig() {
  if (__WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */].prototype[PROP_NAME] && __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */].prototype[PROP_NAME].resetConfig) {
    __WEBPACK_IMPORTED_MODULE_0__vue__["a" /* default */].prototype[PROP_NAME].resetConfig();
  }
};

/***/ })
]));