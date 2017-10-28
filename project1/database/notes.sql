CREATE Table Note {
    noteID INTEGER PRIMARY KEY,
    noteOwner INTEGER REFERENCES User,
    noteText VARCHAR NOT NULL
}
