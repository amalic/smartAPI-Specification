Object | Field | Recommendation | Datatype | Description
---|:---:|:---:|:---:|---
OpenAPI Object|x-externalResources||External Resource Object|A list of external resources pertinent to the API.
Info Object|description|SHOULD| string |See <a href="https://github.com/WebsmartAPI/OpenAPI-Specification/blob/OpenAPI.next/versions/3.0.md#fixed-fields-1">above</a>.
Info Object|termsOfService|REQUIRED| URL |See <a href="https://github.com/WebsmartAPI/OpenAPI-Specification/blob/OpenAPI.next/versions/3.0.md#fixed-fields-1">above</a>.
Info Object|version|REQUIRED| string |The version of the API definition. Specify API version using <a href="http://semver.org/spec/v2.0.0.html">Semantic Versioning<a/>. The major.minor portion of the semver (for example 3.0) shall designate the feature set. Typically, .patch versions address errors in the API metadata, not the feature set.
Info Object|x-maturity|| enum |Maturity of the API. Values to use: development, production.
Info Object|x-accessRestriction|| enum |Indicate whether there are restrictions to using the API. Values to use: none, limited, fee.
Info Object|x-implementationLanguage|| string |Language the API was written in.
Contact Object|x-role|REQUIRED| enum |Indicate the role of the contact. Values can be: `responsible organization`,`responsible developer`,`contributor`,`support`.
Contact Object|x-id|SHOULD| string |Provide a unique identifier for the contact.
Operation Object|summary|REQUIRED| string |See <a href="https://github.com/WebsmartAPI/OpenAPI-Specification/blob/OpenAPI.next/versions/3.0.md#operation-object">above.</a>
Operation Object|x-accessRestriction|| enum |Access restrictions to invoke the operation. values: none, limited, fee.
External Resource Object [smartAPI extension]|x-url|REQUIRED| string |. The URL for the target documentation. Value MUST be in the format of a URL.
External Resource Object [smartAPI extension]|x-type|REQUIRED| enum |values: `api documentation`, `website`,`developer forum`,`mailing list`,`social media`,`publication` </a>
External Resource Object [smartAPI extension]|x-description|| string |A short description of the target documentation. [CommonMark syntax](http://spec.commonmark.org/) can be used for rich text representation.
Parameter Object|x-parameterType|SHOULD| uri |A concept URI to describe the type of parameter.
Parameter Object|x-valueType|SHOULD| [uri] |A list of URIs to define the types of accepted value types. These should be selected from a registry of value types such as identifiers.org.  This attribute is different from
Parameter Object|x-defaultValue|| string |Default value.
Parameter Object|x-exampleValue|| string |Example value.
Response Object|content|| Map[string, [Media Type Object](#mediaTypeObject)] |A map containing descriptions of potential response payloads. The key is the media type and the value is used to describe it.The media type definitions should be in compliance with <a href="http://tools.ietf.org/html/rfc6838">RFC6838</a>.
Response Object|x-responseSchema|| URI |Conformance to a particular schema/format.
Response Object|x-responseValueType|| [responseValueType object] |To specify the types of objects in the response. The responseValueType object consists of a required `x-valueType` that should provide URI values to the type of object, and an optional `x-path` to specify to location in the response for that valueType.
Response Object|x-JSONLDContext|| URI |JSON LD context.
Tag Object|x-id|| URI |The name of the tag. Recommend that you use URI to specify the concept.
