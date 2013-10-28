Database structure
==================

User: ID, Name, EMail, Password

Project: ID, Name, Default_Language

PO-Domain: ID, Name, ProjectID

PO-Dataset: ID, DomainID, msgID, ...

Translation: ID, LanguageID, PODID, msgStr, msgStr1, msgStr2, fuzzy

Language: ID, Name, locale