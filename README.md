# web_project

aws url : https://52.78.183.83

git url : https://github.com/leejonghyuen/web_project

required : 
	> PHP 5.6
	PhalconPHP Framework recently version(installation url : https://docs.phalconphp.com/en/latest/reference/install.html)
	nginx
	https setup(for localhost setup : http://www.queryadmin.com/858/create-self-signed-ssl-certificate-nginx/)

nginx setup : 
	    server {
	        listen       8080 ssl;
	        server_name  localhost;

	        charset utf-8;

	        client_max_body_size 10M;

	        #access_log  logs/host.access.log  main;

	        root   /library/webserver/web_project/public;
	        index  index.php;

	        ssl_certificate      /etc/ssl/certificate.crt;
	        ssl_certificate_key  /etc/ssl/server.key;
	     
	        ssl_session_cache shared:SSL:1m;
	        ssl_session_timeout  5m;
	     
	        ssl_ciphers  HIGH:!aNULL:!MD5;
	        ssl_prefer_server_ciphers   on;

	        location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
		        root /library/webserver/web_project/public/assets;
		    }

	        location / {
	            try_files $uri $uri/ /index.php?$args;
	        }

	        location ~ \.php$ {
	            try_files     $uri =404;

	            fastcgi_pass  127.0.0.1:9000;
	            fastcgi_index /index.php;

	            include fastcgi_params;
	            fastcgi_param DEV_ENV           "develop";
	            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
	            fastcgi_param PATH_INFO       $fastcgi_path_info;
	            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
	            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
	        }
	    }

specification : 