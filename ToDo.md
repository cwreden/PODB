Database structure
==================

User: ID, Name, EMail, Password, createdBy, createDate, lastUpdateBy, lastUpdateDate

Project: ID, Name, Default_Language, createdBy, createDate, lastUpdateBy, lastUpdateDate

PO-Domain: ID, Name, ProjectID, createdBy, createDate, lastUpdateBy, lastUpdateDate

PO-Dataset: ID, DomainID, msgID, ..., createdBy, createDate, lastUpdateBy, lastUpdateDate

Translation: ID, LanguageID, PODID, msgStr, msgStr1, msgStr2, fuzzy, createdBy, createDate, lastUpdateBy, lastUpdateDate

Language: ID, Name, locale, createdBy, createDate, lastUpdateBy, lastUpdateDate