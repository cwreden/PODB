Database structure
==================
- Prefix


User: ID, Name, EMail, Password

Project: ID, Name, Default_Language, users => members and owners

PO-Domain: ID, Name, ProjectID

PO-Dataset: ID, DomainID, msgID, ...

Translation: ID, LanguageID, PODID, msgStr, msgStr1, msgStr2, fuzzy

Language: ID, Name, locale


NEW:
====

ActivationKey: UserId, Key(Hash), Termination, Active

APIKey: UserId, Key(Hash), Active

APIInformation/URLs => urlencode