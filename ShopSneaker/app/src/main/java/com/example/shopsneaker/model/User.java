package com.example.shopsneaker.model;

public class User {
    Integer accountid;
    String username;
    String password;
    int rolesid;
    String name;
    String address;
    String email;
    byte enabled;


    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public byte getEnabled() {
        return enabled;
    }

    public void setEnabled(byte enabled) {
        this.enabled = enabled;
    }

    //

    public User() {
    }

    public User(Integer accountid, String username, String password, int rolesid, String name, String address, String email, byte enabled) {
        this.accountid = accountid;
        this.username = username;
        this.password = password;
        this.rolesid = rolesid;
        this.name = name;
        this.address = address;
        this.email = email;
        this.enabled = enabled;
    }

    public Integer getAccountid() {
        return accountid;
    }

    public void setAccountid(Integer accountid) {
        this.accountid = accountid;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }
    public int getRolesid() {
        return rolesid;
    }

    public void setRolesid(int rolesid) {
        this.rolesid = rolesid;
    }



}
