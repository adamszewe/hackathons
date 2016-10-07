-- @author Adam Szewera



DROP TABLE IF EXISTS TelegramUser;

-- User data
CREATE TABLE TelegramUser
(
  'id'          int primary key,  -- telegram id of the user
  'first_name'  text not null,    -- first name, it is mandatory
  'last_name'   text not null,    -- optional in telegram
  'username'    text not null,    -- optional in telegram
  'tstamp'      int not null      -- unix timestamp of when the user was added to the db
);



DROP TABLE IF EXISTS SecretCode;

-- authorized keys to access special content
-- todo: a cron job should check whether codes in this table are still valid
CREATE TABLE SecretCode
(
  'id'      int primary key,      -- unique id of the code
  'code'    text unique not null, -- the value of the code
  'user_id' int not null,         -- foreign key
  'tstamp'  int not null          -- unix timestamp of when the code was generated
);



DROP TABLE IF EXISTS TextMessage;

-- TextMessage
-- Text messages sent by each user
CREATE TABLE TextMessage
(
  'id'      int primary key,      -- id of the message
  'user_id' int not null,         -- id of the user who sent the message
  'tstamp'  int not null,         -- unix timestamp of when the code was generated
  'text'    text not null         -- text value of the message
);

DROP TABLE IF EXISTS BotCommand;


-- Command
-- commands issued by each user, it's a command log / history
CREATE TABLE BotCommand (
  'id'      int primary key,      -- id of the row
  'user_id' int not null,         -- id of the user who issued the command
  'tstamp'  int not null,         -- unix timestamp of when the command was sent
  'text'    text not null         -- text value of the command
);


DROP TABLE IF EXISTS DefaultResponse;

-- DefaultResponse
-- used so the bot can choose randomly a friendly response for the users
-- CREATE TABLE DefaultResponse
-- (
--   'id'    int primary key,      -- id of the msg
--   'text'  text not null,        -- a message
-- );






