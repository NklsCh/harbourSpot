{ pkgs, config, ... }:
let
  phpPackage = pkgs.php.buildEnv {
    extraConfig = ''
      memory_limit = 256M
    '';
  };
in
{
  languages.php.enable = true;
  languages.php.package = phpPackage;
  languages.php.fpm.pools.web = {
    settings = {
      "pm" = "dynamic";
      "pm.max_children" = 5;
      "pm.start_servers" = 2;
      "pm.min_spare_servers" = 1;
      "pm.max_spare_servers" = 5;
    };
  };

  services.mysql.enable = true;
  services.mysql.package = pkgs.mariadb;
  services.mysql.initialDatabases = [{ name = "app"; }];
  services.mysql.ensureUsers = [
    {
      name = "app";
      password = "app";
      ensurePermissions = { "app.*" = "ALL PRIVILEGES"; };
    }
  ];

  services.caddy.enable = true;
  services.caddy.virtualHosts."http://localhost:8080" = {
    extraConfig = ''
      root * public
      php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
      file_server
    '';
  };

  # Adding Adminer directly in the environment
  services.caddy.virtualHosts."http://localhost:8081" = {
    extraConfig = ''
      root * adminer
      php_fastcgi unix/${config.languages.php.fpm.pools.web.socket}
      file_server
    '';
  };
}

